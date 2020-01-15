<?php

namespace Doublespark\ContaoForumBridgeBundle\EventListener;

use Contao\Config;
use Contao\Database;

/**
 * Class SetNewPasswordListener
 *
 * @package Doublespark\ContaoForumBridgeBundle\EventListener
 */
class SetNewPasswordListener extends ForumBridgeEventListener {

    /**
     * @param $member
     * @param string $password
     */
    public function onSetNewPassword($member, string $password): void
    {
        if(Config::get('phpbb_bridge_enabled'))
        {
            $prefix = Config::get('phpbb_prefix');

            // Update phpBB user table
            Database::getInstance()
                ->prepare('UPDATE '.$prefix.'users SET user_password=? WHERE user_id=?')
                ->execute($member->password, $member->phpbb_user_id);
        }
    }
}