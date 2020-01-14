<?php

namespace Doublespark\ContaoForumBridgeBundle\EventListener;

use Contao\Config;
use Contao\Database;
use Contao\FrontendUser;
use Contao\Module;
use Doublespark\ContaoForumBridgeBundle\Library\StringHelper;

/**
 * Class UpdatePersonalDataListener
 *
 * @package Doublespark\ContaoForumBridgeBundle\EventListener
 */
class UpdatePersonalDataListener extends ForumBridgeEventListener {

    /**
     * @param FrontendUser $member
     * @param array $data
     * @param Module $module
     */
    public function onUpdatePersonalData(FrontendUser $member, array $data, Module $module): void
    {
        if(Config::get('phpbb_bridge_enabled'))
        {
            $prefix = Config::get('phpbb_prefix');

            $usernameClean = StringHelper::Utf8Clean($member->username);

            // Update phpBB user table
            Database::getInstance()
                ->prepare('UPDATE '.$prefix.'users SET username=?,username_clean=?,user_email=?,user_password=? WHERE user_id=?')
                ->execute($member->username, $usernameClean, $member->email, $member->password, $member->phpbb_user_id);
        }
    }
}