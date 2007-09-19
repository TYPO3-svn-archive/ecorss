<?php

########################################################################
# Extension Manager/Repository config file for ext: "eco_rss"
#
# Auto generated 12-04-2007 09:51
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Ecodev : rss services',
	'description' => 'Generate a RSS feed based on the latest content of a SQL table.',
	'category' => 'fe',
	'author' => 'Fabien Udriot',
	'author_email' => 'fabien.udriot@ecodev.ch',
	'shy' => '',
	'dependencies' => 'cms,div,lib',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.1.0',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'div' => '',
			'lib' => '',
			'typo3' => '4.0.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:18:{s:9:"ChangeLog";s:4:"b528";s:10:"README.txt";s:4:"1ecf";s:12:"ext_icon.gif";s:4:"baa5";s:17:"ext_localconf.php";s:4:"6a13";s:14:"ext_tables.php";s:4:"4f61";s:14:"ext_tables.sql";s:4:"685a";s:16:"locallang_db.xml";s:4:"1ef5";s:14:"doc/manual.sxw";s:4:"d1e5";s:31:"pi1/class.tx_ecocontent_pi1.php";s:4:"be68";s:39:"pi1/class.tx_ecocontent_pi1_wizicon.php";s:4:"0ec2";s:15:"pi1/ds/data.xml";s:4:"a4cd";s:23:"pi1/img/emailButton.png";s:4:"4ef8";s:22:"pi1/img/pdf_button.png";s:4:"393c";s:28:"pi1/lib/class.appManager.php";s:4:"04ba";s:26:"pi1/tpl/ecocontent_pi1.tpl";s:4:"a63d";s:28:"share/lib/class.treeview.php";s:4:"5959";s:34:"share/lib/class.tx_damSelector.php";s:4:"49d4";s:36:"share/lib/class.ux_ecocontent_kj.php";s:4:"e002";}',
	'suggests' => array(
	),
);
?>