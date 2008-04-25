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
 * $Id$
 *
 * @author	Fabien Udriot <fabien.udriot@ecodev.ch>
 * @package TYPO3
 * @subpackage ecorss
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *   44: class tx_ecorss_views_feed extends tx_lib_phpTemplateEngine
 *   49:     function printSummary()
 *   58:     function printUrl()
 *
 * TOTAL FUNCTIONS: 2
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */
class tx_ecorss_views_feed extends tx_lib_phpTemplateEngine {

	/**
	 * Print the feed's summary.
	 */
	function printSummary() {
		$regex = $result = array();
		
		// thanks to Marius Mühlberger <mm@co-operation.de> for the regular expressions
		// Remove script-tags with content
		$result[] = '';
		$regex[] = '/<( *)script([^>]*)type( *)=( *)([^>]*)>(.*)<\/( *)script( *)>/isU';
		
		// Remove event handler
		$result[] = '';
		$regex[] = '/( *)(on[a-z]{4,10})( *)=( *)"([^"]*)"/isU';
		
		// Remove javascript in url, etc
		$result[] = '""';
		$regex[] = '/"( *)javascript( *):([^"]*)"/isU';
		
		$content = preg_replace($regex,$result, $this->asRte('summary'));
		
		print '<![CDATA['.$content.']]>';
	}

	/**
	 * Print the current url of the page.
	 */
	function printUrl() {
		print $this->asText('host');
		print $this->asText('url');
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ecorss/views/class.tx_ecorss_views_feed.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ecorss/views/class.tx_ecorss_views_feed.php']);
}
?>
