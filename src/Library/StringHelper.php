<?php

namespace Doublespark\ContaoForumBridgeBundle\Library;

/**
 * Class StringHelper
 *
 * @package Doublespark\ContaoForumBridgeBundle\Library
 */
class StringHelper {

    /**
     * Cleans a string, based on phpbb's utf8_clean_string function
     * @param $username
     * @return string
     */
    public static function Utf8Clean($username) : string
    {
        $homographs = include(__DIR__.'/../Includes/confusables.php');

        $username = strtr($username, $homographs);

        // Other control characters
        $username = preg_replace('#(?:[\x00-\x1F\x7F]+|(?:\xC2[\x80-\x9F])+)#', '', $username);

        // we need to reduce multiple spaces to a single one
        $username = preg_replace('# {2,}#', ' ', $username);

        return strtolower(trim($username));
    }
}