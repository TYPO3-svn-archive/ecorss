<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');
//update the extension plugin form in the backend

t3lib_div::loadTCA('tt_content');
t3lib_extMgm::addStaticFile($_EXTKEY, './configurations', 'Ecodev: rss services');// ($extKey, $path, $title)

$pluginKey = 'tx_ecorss_controllers_feed';
t3lib_extMgm::addPlugin(array('LLL:EXT:ecorss/locallang_db.xml:tt_content.list_type_pi1', $pluginKey));// array($title, $pluginKey)
#t3lib_extMgm::addPiFlexFormValue($pluginKey, 'FILE:EXT:ecorss/configurations/flexform.xml');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginKey]='layout,select_key,pages,recursive'; //define the backend display
#$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginKey]='pi_flexform';


?>