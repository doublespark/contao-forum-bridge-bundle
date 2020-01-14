<?php

namespace Doublespark\ContaoForumBridgeBundle\EventListener;

use Contao\Config;
use Contao\Database;
use Contao\System;
use Contao\User;

/**
 * Class PostLogoutListener
 *
 * @package Doublespark\ContaoForumBridgeBundle\EventListener
 */
class PostLogoutListener extends ForumBridgeEventListener {

    /**
     * @param User $user
     */
    public function onPostLogout(User $user): void
    {
        if(Config::get('phpbb_bridge_enabled'))
        {
            if($user->phpbb_user_id > 0)
            {
                $prefix = Config::get('phpbb_prefix');

                // Remove this user's session from phpbb
                Database::getInstance()->prepare('DELETE FROM ' . $prefix . 'sessions WHERE session_user_id=?')->execute($user->phpbb_user_id);

                // Remove the cookie
                $domain = Config::get('phpbb_domain');

                if(empty($domain))
                {
                    $domain = null;
                }

                System::setCookie('phpbridgeuid', 0, time() - 3600, '/', $domain);

                // Remove the user's phpbb session from the database
                Database::getInstance()->prepare('DELETE FROM tl_phpbb_session WHERE member_id=?')->execute($user->id);

                // Log
                $this->logInfo('phpBB user logged out. MemberID: '.$user->id.' phpbbID: '.$user->phpbb_user_id,__METHOD__);
            }
        }
    }
}