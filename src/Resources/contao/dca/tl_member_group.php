<?php

/**
 * Table tl_member_group
 */
$GLOBALS['TL_DCA']['tl_member_group']['palettes']['default'] =  str_replace
(
    '{redirect_legend:hide}',
    '{phpbb_bridge_legend:hide},phpbb_group;{redirect_legend:hide}',
    $GLOBALS['TL_DCA']['tl_member_group']['palettes']['default']
);

$GLOBALS['TL_DCA']['tl_member_group']['fields']['phpbb_group'] = array
(
    'label'            => &$GLOBALS['TL_LANG']['tl_member_group']['phpbb_group'],
    'flag'             => 1,
    'inputType'        => 'select',
    'eval'             => array('mandatory'=>true, 'tl_class'=>'clr'),
    'sql'              => "int(10) unsigned NOT NULL default 0"
);