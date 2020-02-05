<?php

namespace Doublespark\ContaoForumBridgeBundle\EventListener;

use Contao\Config;
use Contao\Database;
use Contao\Environment;
use Contao\FrontendUser;
use Contao\System;
use Doublespark\ContaoForumBridgeBundle\Library\SessionHelper;

/**
 * Class InitializeSystemListener
 *
 * @package Doublespark\ContaoForumBridgeBundle\EventListener
 */
class InitializeSystemListener {

    /**
     * Initialize Contao hook
     */
    public function onInitializeSystem() : void
    {
        if(Config::get('phpbb_bridge_enabled'))
        {
            $hasUser = System::getContainer()->get('contao.security.token_checker')->hasFrontendUser();

            if($hasUser)
            {
                $objUser = FrontendUser::getInstance();

                if(!is_null($objUser->id))
                {
                    $objUser = FrontendUser::getInstance();

                    $domain = Config::get('phpbb_domain');

                    if(empty($domain))
                    {
                        $domain = null;
                    }

                    $ua         = Environment::get('httpUserAgent');
                    $ip         = Environment::get('ip');
                    $lastActive = time();
                    $expires    = Config::get('sessionTimeout') + $lastActive;

                    $sessionKey = SessionHelper::getSessionKey($objUser->id);

                    System::setCookie('phpbridgeuid', $sessionKey, 0, '/', $domain);

                    // Create or update the session record
                    $objCount = Database::getInstance()->prepare('SELECT COUNT(*) AS count FROM tl_phpbb_session WHERE session_key=?')->execute($sessionKey);

                    if($objCount->count > 0)
                    {
                        Database::getInstance()->prepare('UPDATE tl_phpbb_session SET last_active=?, expires=?')->execute($lastActive, $expires);
                    }
                    else
                    {
                        Database::getInstance()->prepare('INSERT INTO tl_phpbb_session SET member_id=?, ip_address=?, user_agent=?, session_key=?, last_active=?, expires=?')->execute($objUser->id, $ip, $ua, $sessionKey, $lastActive, $expires);
                    }
                }
            }
        }
    }
}