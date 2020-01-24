<?php

namespace Doublespark\ContaoForumBridgeBundle\EventListener\Dca;

use Contao\Config;
use Contao\Database;
use Contao\DataContainer;
use Contao\System;
use Doublespark\ContaoForumBridgeBundle\Client\PhpBB;
use Doublespark\ContaoForumBridgeBundle\EventListener\ForumBridgeEventListener;

/**
 * Class SettingsListener
 *
 * @package Doublespark\ContaoForumBridgeBundle\EventListener\Dca
 */
class SettingsListener extends ForumBridgeEventListener {

    /**
     * @return array
     */
    public function onGetGroupOptions(): array
    {
        $arrOptions = [];

        if(Config::get('phpbb_bridge_enabled'))
        {
            $prefix = Config::get('phpbb_prefix');

            $objResult = Database::getInstance()->query('SELECT * FROM '.$prefix.'groups ORDER BY group_name ASC');

            if($objResult)
            {
                while($objResult->next())
                {
                    $arrOptions[$objResult->group_id] = $objResult->group_name;
                }
            }
        }

        return $arrOptions;
    }
}