<?php

########################################################################
# Extension Manager/Repository config file for ext: "ecorss"
#
# Auto generated 18-10-2008 11:19
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
	'version' => '0.6.2',
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
	'author' => 'Fabien Udriot / Xavier Perseguers',
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
	'_md5_values_when_last_written' => 'a:22:{s:13:"ChangeLog.txt";s:4:"e364";s:12:"ext_icon.gif";s:4:"e0fc";s:12:"ext_icon.png";s:4:"4de9";s:17:"ext_localconf.php";s:4:"806c";s:14:"ext_tables.php";s:4:"eb65";s:14:"ext_tables.sql";s:4:"b53c";s:24:"ext_typoscript_setup.txt";s:4:"68b7";s:30:"icon_tx_ecobox_publication.png";s:4:"655f";s:13:"locallang.xml";s:4:"0073";s:16:"locallang_db.xml";s:4:"8c4a";s:28:"configurations/constants.txt";s:4:"82c7";s:24:"configurations/setup.txt";s:4:"a26d";s:48:"controllers/class.tx_ecorss_controllers_feed.php";s:4:"78dc";s:55:"controllers/class.tx_ecorss_controllers_feed.php.source";s:4:"12ea";s:49:"controllers/class.tx_ecorss_controllers_feed2.php";s:4:"108e";s:28:"controllers/ecorss-url2.diff";s:4:"bebc";s:14:"doc/manual.pdf";s:4:"50fe";s:14:"doc/manual.sxw";s:4:"a5f8";s:38:"models/class.tx_ecorss_models_feed.php";s:4:"8243";s:18:"templates/atom.php";s:4:"962c";s:17:"templates/rss.php";s:4:"9741";s:36:"views/class.tx_ecorss_views_feed.php";s:4:"58c8";}',
	'suggests' => array(
	),
);

?>