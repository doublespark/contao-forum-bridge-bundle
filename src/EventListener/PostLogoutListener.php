<?php

namespace Doublespark\ContaoForumBridgeBundle\EventListener;

use Contao\Config;
use Contao\Database;
use Contao\System;
use Contao\User;
use Doublespark\ContaoForumBridgeBundle\Library\SessionHelper;

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

                // Get the session key
                $sessionKey = SessionHelper::getSessionKey($user->id);

                /**
                 * Get the phpBB session ID
                 */
                $objResult = Database::getInstance()->prepare('SELECT phpbb_session_id FROM tl_phpbb_session WHERE session_key=?')->limit(1)->execute($sessionKey);

                // Remove this user's session from phpbb
                if($objResult->phpbb_session_id)
                {
                    // If we have a session ID, remove just that session
                    Database::getInstance()->prepare('DELETE FROM ' . $prefix . 'sessions WHERE session_id=?')->execute($objResult->phpbb_session_id);
                }
                else
                {
                    // If we have no session ID just remove all sessions for this user
                    Database::getInstance()->prepare('DELETE FROM ' . $prefix . 'sessions WHERE session_user_id=?')->execute($user->phpbb_user_id);
                }

                // Remove the cookie
                $domain = Config::get('phpbb_domain');

                if(empty($domain))
                {
                    $domain = null;
                }

                // Clear cookie
                System::setCookie('phpbridgeuid', 0, time() - 3600, '/', $domain);

                // Remove the user's phpbb session from the contao database
                Database::getInstance()->prepare('DELETE FROM tl_phpbb_session WHERE session_key=?')->execute($sessionKey);

                // Log
                $this->logInfo('phpBB user logged out. MemberID: '.$user->id.' phpbbID: '.$user->phpbb_user_id,__METHOD__);
            }
        }
    }
}