<?php

namespace Doublespark\ContaoForumBridgeBundle\EventListener\Dca;

use Contao\Config;
use Contao\Database;

/**
 * Class MemberGroupTableListener
 *
 * @package Doublespark\ContaoForumBridgeBundle\EventListener\Dca
 */
class MemberGroupTableListener {

    /**
     * Gets available groups from phpBB
     * @return array
     */
    public function onGetGroupOptions() : array
    {
        if(!Config::get('phpbb_bridge_enabled'))
        {
            return [0 => 'Forum Bridge Disabled'];
        }

        $arrOptions = [];

        $prefix = Config::get('phpbb_prefix');

        // Map friendly names to default groups
        $defaultGroups = [
            'REGISTERED'        => 'Registered users',
            'REGISTERED_COPPA'  => 'Registered COPPA users',
            'GLOBAL_MODERATORS' => 'Global moderators',
            'ADMINISTRATORS'    => 'Administrators'
        ];

        $arrIgnoredGroups = ['BOTS','NEWLY_REGISTERED','GUESTS'];

        $objResult = Database::getInstance()->query('SELECT * FROM '.$prefix.'groups ORDER BY group_name ASC');

        if($objResult)
        {
            while($objResult->next())
            {
                if(in_array($objResult->group_name,$arrIgnoredGroups))
                {
                    continue;
                }

                $name = $objResult->group_name;

                if(isset($defaultGroups[$name]))
                {
                    $name = $defaultGroups[$name];
                }

                $arrOptions[$objResult->group_id] = $name;
            }
        }

        return $arrOptions;
    }
}