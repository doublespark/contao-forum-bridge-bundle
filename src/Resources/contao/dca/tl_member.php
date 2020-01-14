<?php

$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] =  str_replace
(
    '{login_legend}',
    '{phpbb_bridge_legend:hide},phpbb_user_id;{login_legend}',
    $GLOBALS['TL_DCA']['tl_member']['palettes']['default']
);

$GLOBALS['TL_DCA']['tl_member']['fields']['phpbb_user_id'] = array
(
    'label'            => &$GLOBALS['TL_LANG']['tl_member']['phpbb_user_id'],
    'flag'             => 1,
    'inputType'        => 'select',
    'eval'             => array('mandatory'=>true, 'tl_class'=>'clr'),
    'sql'              => "int(10) unsigned NOT NULL default 0"
);