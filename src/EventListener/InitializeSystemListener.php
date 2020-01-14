<?php

namespace Doublespark\ContaoForumBridgeBundle\EventListener;

use Contao\Config;
use Contao\Database;
use Contao\Environment;
use Contao\FrontendUser;
use Contao\System;

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
            $loggedIn = System::getContainer()->get('contao.security.token_checker')->hasFrontendUser();

            if($loggedIn)
            {
                $objUser = FrontendUser::getInstance();

                $domain = Config::get('phpbb_domain');

                if(empty($domain))
                {
                    $domain = null;
                }

                System::setCookie('phpbridgeuid', $objUser->id, 0, '/', $domain);

                // Create or update the session record
                $objCount = Database::getInstance()->prepare('SELECT COUNT(*) AS count FROM tl_phpbb_session WHERE member_id=?')->execute($objUser->id);

                $ip         = Environment::get('ip');
                $lastActive = time();
                $expires    = Config::get('sessionTimeout') + $lastActive;

                if($objCount->count > 0)
                {
                    Database::getInstance()->prepare('UPDATE tl_phpbb_session SET ip_address=?, last_active=?, expires=?')->execute($ip, $lastActive, $expires);
                }
                else
                {
                    Database::getInstance()->prepare('INSERT INTO tl_phpbb_session SET member_id=?, ip_address=?, last_active=?, expires=?')->execute($objUser->id, $ip, $lastActive, $expires);
                }
            }
        }
    }
}