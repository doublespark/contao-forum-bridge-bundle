<?php

namespace Doublespark\ContaoForumBridgeBundle\Library;

use Contao\Environment;

/**
 * Class SessionHelper
 *
 * @package Doublespark\ContaoForumBridgeBundle\Library
 */
class SessionHelper {

    /**
     * Returns the session key
     * @return string
     */
    public static function getSessionKey($userId) : string
    {
        $ua = Environment::get('httpUserAgent');
        $ip = Environment::get('ip');
        return md5($ua.$ip.$userId);
    }
}