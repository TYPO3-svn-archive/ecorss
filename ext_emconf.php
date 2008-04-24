<?php

########################################################################
# Extension Manager/Repository config file for ext: "ecorss"
#
# Auto generated 03-03-2008 08:56
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Ecodev : feeds services (RSS / ATOM)',
	'description' => 'Generate *quickly* and *easily* RSS / ATOM feeds based on the latest content of a SQL table. Can deal with flexform content and multilingual websites.',
	'category' => 'fe',
	'shy' => 0,
	'version' => '0.4.1',
	'dependencies' => 'cms,div,lib',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Fabien Udriot / Xavier Perseguers' ,
	'author_email' => 'fabien.udriot@ecodev.ch',
	'author_company' => 'Ecodev',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'div' => '0.1.0-0.0.0',
			'lib' => '0.1.0-0.0.0',
			'typo3' => '4.0.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:17:{s:9:"ChangeLog";s:4:"79e9";s:10:"README.txt";s:4:"e28f";s:12:"ext_icon.gif";s:4:"e0fc";s:12:"ext_icon.png";s:4:"4de9";s:17:"ext_localconf.php";s:4:"0b4a";s:14:"ext_tables.php";s:4:"505f";s:30:"icon_tx_ecobox_publication.png";s:4:"655f";s:13:"locallang.xml";s:4:"0073";s:16:"locallang_db.xml";s:4:"2e5c";s:38:"models/class.tx_ecorss_models_feed.php";s:4:"bf1b";s:14:"doc/manual.sxw";s:4:"2e6b";s:28:"configurations/constants.txt";s:4:"82c7";s:24:"configurations/setup.txt";s:4:"a26d";s:48:"controllers/class.tx_ecorss_controllers_feed.php";s:4:"8b8e";s:18:"templates/atom.php";s:4:"8a26";s:17:"templates/rss.php";s:4:"9741";s:36:"views/class.tx_ecorss_views_feed.php";s:4:"f1f7";}',
);

?>
