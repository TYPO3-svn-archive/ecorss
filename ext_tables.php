<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');
//update the extension plugin form in the backend


$tempColumns = Array (
	'tx_ecorss_excludeFromFeed' => Array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:ecorss/locallang_db.xml:excludeFromFeed',
		'config' => Array (
			'type' => 'check',
			"default" => "0",
		)
	),
);

t3lib_div::loadTCA('tt_content');
t3lib_extMgm::addTCAcolumns('tt_content',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('tt_content','tx_ecorss_excludeFromFeed','','after:hidden');

t3lib_extMgm::addStaticFile($_EXTKEY, './configurations', 'Ecodev: rss services');// ($extKey, $path, $title)
t3lib_extMgm::addPlugin(array('LLL:EXT:ecorss/locallang_db.xml:tt_content.list_type_pi1', 'tx_ecorss_controllers_feed'));

?>