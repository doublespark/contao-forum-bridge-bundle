<?php

namespace Doublespark\ContaoForumBridgeBundle\Factory;

use Contao\Config;
use Doublespark\ContaoForumBridgeBundle\Client\PhpBB;
use GuzzleHttp\Client;

/**
 * Class PhpBBStaticFactory
 *
 * @package Doublespark\ContaoForumBridgeBundle\Factory
 */
class PhpBBStaticFactory {

    /**
     * Creates PhpBB class
     * @return PhpBB
     * @throws \Exception
     */
    public static function createPhpBB()
    {
        $httpClient = new Client();

        $apiUrl  = Config::get('phpbb_base_url');
        $apiPath = Config::get('phpbb_bridge_api_path');

        if(empty($apiUrl))
        {
            throw new \Exception('phpBB bridge is enabled but no base URL is configured in Contao settings.');
        }

        $phpBB = new PhpBB($httpClient, $apiUrl, $apiPath);

        $secretKey = Config::get('phpbb_secret_key');

        $phpBB->setSecretKey($secretKey);

        return $phpBB;
    }
}