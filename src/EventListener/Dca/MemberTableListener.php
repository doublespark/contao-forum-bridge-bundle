<?php

namespace Doublespark\ContaoForumBridgeBundle\EventListener\Dca;

use Contao\Config;
use Contao\Database;
use Contao\DataContainer;
use Contao\System;
use Doublespark\ContaoForumBridgeBundle\Client\PhpBB;
use Doublespark\ContaoForumBridgeBundle\EventListener\ForumBridgeEventListener;

/**
 * Class MemberTableListener
 *
 * @package Doublespark\ContaoForumBridgeBundle\EventListener\Dca
 */
class MemberTableListener extends ForumBridgeEventListener {

    /**
     * @param DataContainer $dc
     * @param $undoId
     */
    public function onDeleteCallback(DataContainer $dc, $undoId)
    {
        if(Config::get('phpbb_bridge_enabled'))
        {
            $contaoMemberId = $dc->id;
            $phpbbUserId    = $dc->activeRecord->phpbb_user_id;

            // Remove the user's phpbb session from the database
            Database::getInstance()->prepare('DELETE FROM tl_phpbb_session WHERE member_id=?')->execute($dc->id);

            /**
             * @var PhpBB $phpBB
             */
            $phpBB = System::getContainer()->get('doublespark.forum_bridge.phpbb');

            try {

                $arrResponse = $phpBB->deleteUser($dc->activeRecord->phpbb_user_id);

            } catch(\Exception $e) {

                $this->logError($e->getMessage(),__METHOD__);
                return;
            }

            if($arrResponse['status'] === 'success')
            {
                $this->logInfo('phpBB user deleted. MemberID: '.$contaoMemberId.' phpbbID: '.$phpbbUserId, __METHOD__);
            }
            else
            {
                $this->logError('Could not delete phpBB user. MemberID: '.$contaoMemberId.' phpbbID: '.$phpbbUserId.' '.$arrResponse['message'], __METHOD__);
            }
        }
    }

    /**
     * Gets members from phpBB
     * @return array
     */
    public function onGetPhpBBMemberOptions() : array
    {
        if(!Config::get('phpbb_bridge_enabled'))
        {
            return [0 => 'Forum Bridge Disabled'];
        }

        $arrOptions = [];

        $arrOptions[0] = 'None';

        $prefix = Config::get('phpbb_prefix');

        $objPhpBBUsers = Database::getInstance()->query('SELECT user_id, user_type, username, user_email FROM '.$prefix.'users WHERE user_type !=2 ORDER BY username ASC');

        if($objPhpBBUsers)
        {
            while($objPhpBBUsers->next())
            {
                $arrOptions[$objPhpBBUsers->user_id] = $objPhpBBUsers->username.' ('.$objPhpBBUsers->user_email.')'.($objPhpBBUsers->user_type == 3 ? ' [ADMIN]' : '');;
            }
        }

        return $arrOptions;
    }

    /**
     * @param $value
     * @param DataContainer $dc
     * @return mixed
     */
    public function onSavePhpBBGroup($value, DataContainer $dc)
    {
        if(Config::get('phpbb_bridge_enabled'))
        {
            $userId  = $dc->activeRecord->phpbb_user_id;
            $groupId = $value;

            // Don't sync
            if($value == 99999 || $value == '')
            {
                return $value;
            }

            /**
             * @var PhpBB $phpBB
             */
            $phpBB = System::getContainer()->get('doublespark.forum_bridge.phpbb');

            try {

                $phpBB->changeUserGroup($userId, $groupId);

            } catch(\Exception $e) {

                $this->logError($e->getMessage(),__METHOD__);
                return;
            }
        }

        return $value;
    }
}