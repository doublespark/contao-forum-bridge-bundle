<?php

/**
 * Table tl_phpbb_session
 */
$GLOBALS['TL_DCA']['tl_phpbb_session'] = array
(
    // Config
    'config'      => array
    (
        'dataContainer' => 'Table',
        'sql'           => array
        (
            'keys' => array
            (
                'id'        => 'primary',
                'member_id' => 'index'
            )
        )
    ),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'last_active' => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'expires' => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'member_id' => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'ip_address' => array
        (
            'sql' => "varchar(255) NOT NULL default ''"
        ),
    )
);