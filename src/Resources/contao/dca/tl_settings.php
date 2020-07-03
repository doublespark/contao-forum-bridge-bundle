<?php

/**
 * Table tl_settings
 */
use Contao\CoreBundle\DataContainer\PaletteManipulator;

PaletteManipulator::create()
    ->addLegend('phpbb_bridge_legend', null, PaletteManipulator::POSITION_AFTER, true)
    ->addField('phpbb_bridge_enabled', 'phpbb_bridge_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('phpbb_group_options', 'phpbb_bridge_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('phpbb_secret_key', 'phpbb_bridge_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('phpbb_domain', 'phpbb_bridge_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('phpbb_base_url', 'phpbb_bridge_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('phpbb_register_page', 'phpbb_bridge_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('phpbb_login_page', 'phpbb_bridge_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('phpbb_logout_page', 'phpbb_bridge_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('phpbb_account_page', 'phpbb_bridge_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_settings')
;

// Fields
$GLOBALS['TL_DCA']['tl_settings']['fields']['phpbb_bridge_enabled'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['phpbb_bridge_enabled'],
    'inputType' => 'checkbox',
    'default'   => 1,
    'eval'      => array('mandatory'=>false)
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['phpbb_secret_key'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['phpbb_secret_key'],
    'inputType' => 'text',
    'default'   => '',
    'eval'      => array('mandatory'=>true, 'nospace'=>true)
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['phpbb_domain'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['phpbb_domain'],
    'inputType' => 'text',
    'default'   => '',
    'eval'      => array('mandatory'=>true, 'nospace'=>true)
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['phpbb_base_url'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['phpbb_base_url'],
    'inputType' => 'text',
    'default'   => '',
    'eval'      => array('mandatory'=>true, 'nospace'=>true)
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['phpbb_prefix'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['phpbb_prefix'],
    'inputType' => 'text',
    'default'   => '',
    'eval'      => array('mandatory'=>true, 'nospace'=>true)
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['phpbb_login_page'] = array
(
    'label'      => &$GLOBALS['TL_LANG']['tl_settings']['phpbb_login_page'],
    'inputType'  => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval'       => array('mandatory'=>true, 'fieldType'=>'radio')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['phpbb_account_page'] = array
(
    'label'      => &$GLOBALS['TL_LANG']['tl_settings']['phpbb_account_page'],
    'inputType'  => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval'       => array('mandatory'=>true, 'fieldType'=>'radio')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['phpbb_register_page'] = array
(
    'label'      => &$GLOBALS['TL_LANG']['tl_settings']['phpbb_register_page'],
    'inputType'  => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval'       => array('mandatory'=>true, 'fieldType'=>'radio')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['phpbb_logout_page'] = array
(
    'label'      => &$GLOBALS['TL_LANG']['tl_settings']['phpbb_logout_page'],
    'inputType'  => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval'       => array('mandatory'=>true, 'fieldType'=>'radio')
);

// Select which group options are available
$GLOBALS['TL_DCA']['tl_settings']['fields']['phpbb_group_options'] = array
(
    'label'      => &$GLOBALS['TL_LANG']['tl_settings']['phpbb_group_options'],
    'inputType'  => 'checkbox',
    'eval'       => array('multiple'=>true)
);