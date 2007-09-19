<?php
/***************************************************************
 *	Copyright notice
 *
 *	(c) 2007 Fabien Udriot <fabien.udriot@ecodev.ch>
 *	All rights reserved
 *
 *	This script is part of the TYPO3 project. The TYPO3 project is
 *	free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation; either version 2 of the License, or
 *	(at your option) any later version.
 *
 *	The GNU General Public License can be found at
 *	http://www.gnu.org/copyleft/gpl.html.
 *
 *	This script is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
 *	GNU General Public License for more details.
 *
 *	This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * Plugin 'RSS services' for the 'ecorss' extension.
 *
 * @author	Fabien Udriot <fabien.udriot@ecodev.ch>
 * @package TYPO3
 * @subpackage ecorss
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 */

class tx_ecorss_views_feed extends tx_lib_phpTemplateEngine {
	
	function printSummary(){
		$content = str_replace('<p>','',$this->asRte('summary'));
		print str_replace('</p>','',$content);
	}
	
	/**
	 * print the current url of the page
	 *
	 */
	function printUrl(){
		print 'http://'.t3lib_div::getIndpEnv('HTTP_HOST');
		print $this->asText('url');
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ecorss/views/class.tx_ecorss_views_feed.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ecorss/views/class.tx_ecorss_views_feed.php']);
}
?>
