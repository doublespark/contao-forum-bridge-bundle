<?php

namespace Doublespark\ContaoForumBridgeBundle\EventListener;

use Contao\Config;
use Contao\Database;
use Contao\Input;
use Contao\MemberGroupModel;
use Contao\Module;
use Contao\System;
use Doublespark\ContaoForumBridgeBundle\Client\PhpBB;

/**
 * Class CreateNewUserListener
 *
 * @package Doublespark\ContaoForumBridgeBundle\EventListener
 */
class CreateNewUserListener extends ForumBridgeEventListener {

    /**
     * @param int $userId
     * @param array $userData
     * @param Module $module
     * @throws \Exception
     */
    public function onCreateNewUser(int $userId, array $userData, Module $module): void
    {
        if(Config::get('phpbb_bridge_enabled'))
        {
            // Default to registered users
            $phpbb_group = 2;

            // See if we can find a phpBB group associated
            // with the Contao member group
            if(!empty($userData['groups']))
            {
                $arrGroups = unserialize($userData['groups']);

                if(is_array($arrGroups))
                {
                    foreach($arrGroups as $groupId)
                    {
                        $objGroup = MemberGroupModel::findById($groupId);

                        if($objGroup->phpbb_group > 0)
                        {
                            $phpbb_group = $objGroup->phpbb_group;
                            break;
                        }
                    }
                }
            }

            // User data to send to phpBB
            $username = $userData['username'];
            $password = $userData['password']; // we can send hashed password straight to phpBB
            $email    = strtolower($userData['email']);
            $group_id = $phpbb_group;

            /**
             * @var PhpBB $phpBB
             */
            $phpBB = System::getContainer()->get('doublespark.forum_bridge.phpbb');

            try {

                $arrResponse = $phpBB->createUser($username, $password, $email, $group_id);

            } catch(\Exception $e) {

                $this->logError($e->getMessage(),__METHOD__);
                return;
            }

            if($arrResponse['status'] === 'success')
            {
                $phpbbUserId = $arrResponse['data']['user_id'];

                // Save the phpbb user ID to the Contao member
                Database::getInstance()->prepare('UPDATE tl_member SET phpbb_user_id=?,phpbb_group=? WHERE id=?')->execute($phpbbUserId,$phpbb_group,$userId);

                $this->logInfo('phpBB user created. MemberID: '.$userId.' phpbbID: '.$phpbbUserId, __METHOD__);
            }
            else
            {
                $this->logError('Could not create phpBB user for member: '.$userId.'. Error: '.$arrResponse['message'], __METHOD__);
            }
        }
    }
}