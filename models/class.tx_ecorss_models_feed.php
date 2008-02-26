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
 * Plugin 'RSS Services' for the 'ecorss' extension.
 *
 * $Id$
 *
 * @author	Fabien Udriot <fabien.udriot@ecodev.ch>
 * @author  Xavier Perseguers <xavier@perseguers.ch>
 * @package TYPO3
 * @subpackage ecorss
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *   45: class tx_ecorss_models_feed extends tx_lib_object
 *   52:     function load()
 *  181:     function getAllPages($pid, &$arrayOfPid = array())
 *
 * TOTAL FUNCTIONS: 2
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */
class tx_ecorss_models_feed extends tx_lib_object {

	/**
	 * Initialize the modem, parse the TS configuration and prepare the list of updated pages for the feed.
	 * 
	 * @access public
	 */
	public function load() {
		//init a few variables
		$pidRootline = $this->controller->configurations['pidRootline'];
		$sysLanguageUid = isset($this->controller->configurations['sysLanguageUid']) ? $this->controller->configurations['sysLanguageUid'] : null;
		$configurations = is_array($this->controller->configurations['select.']) ? $this->controller->configurations['select.'] : array(0);
		$limitSQL = isset($this->controller->configurations['numberItems']) ? $this->controller->configurations['numberItems'] : '10';
		$entries = array();
		$linkClass = tx_div::makeInstance('tx_lib_link');

		$className = tx_div::makeInstance('tx_lib_link');
		$link = new $className();
		$link->noHash();

		foreach ($configurations as $config) {

			// Initialize some variables
			$summary = $title = '';

			/* PROCESS THE TITLE */
			if (isset($config['titleXPath'])) {
				$flexFormField = $config['title'] != '' ? $config['title'] : 'pi_flexform';
				$title .= "EXTRACTVALUE(".$flexFormField.",'".$config['titleXPath']."')";
			} else {
				$title = isset($config['title']) ? $config['title'] : 'header';
			}

			/* PROCESS THE SUMMARY */
			if (isset($config['summaryXPath'])) {
				$flexFormField = $config['summary'] != '' ? $config['summary'] : 'pi_flexform';
				$summary .= "EXTRACTVALUE(".$flexFormField.",'".$config['summaryXPath']."')";
			} else {
				$summary = isset($config['summary']) ? $config['summary'] : 'bodytext';
			}

			/* PROCESS THE OTHER FIELDS */
			$published = isset($config['published']) ? $config['published'] : 'tstamp';
			$updated = isset($config['updated']) ? $config['updated'] : 'tstamp';
			$uid = isset($config['uid']) ? $config['uid'] : 'uid';

			$pid = isset($config['pid']) ? $config['pid'] : 'pid';
			$fieldSQL = $pid.' as pid, '.$uid.' as uid, '.$title.' as title, '.$summary.' as summary, '.$published.' as published, '.$updated.' as updated';

			/* PROCESS THE CLAUSE */
			$clauseSQL = 'hidden=0 and deleted=0';
			//select some field according to the configuration
			if (isset($config['filterField']) && isset($config['filterInclude'])) {
				$values = explode(',',$config['filterInclude']);
				foreach ($values as $value) {
					$clauseSQL .= ' AND '.$config['filterField'].'="'.trim($value).'"';
				}
			}
			// Exclude some field according to the configuration
			if (isset($config['filterField']) && isset($config['filterExclude'])) {
				$values = explode(',',$config['filterExclude']);
				foreach ($values as $value) {
					$clauseSQL .= ' AND '.$config['filterField'].'!="'.trim($value).'"';
				}
			}
			// Check if the page is in the root line
			if ($pidRootline != null) {
				$pages = $this->getAllPages($pidRootline);
				$pageClauseSQL = 'pid='.$pidRootline;
				foreach ($pages as $page) {
					$pageClauseSQL .= ' OR pid='.$page['uid'];
				}
				$clauseSQL .= ' AND ('.$pageClauseSQL.')'; #merge of the two clauses
			}
			// Only return selected language content
			if ($sysLanguageUid != null) {
				$clauseSQL .= ' AND sys_language_uid='.$sysLanguageUid;
			}
			$table = $config['table'] != '' ? $config['table'] : 'tt_content';

			$debug = isset($config['debug']) ? $config['debug'] : 'false';
			if ($debug == 'true' || $debug == 1) {
				print tx_div::db()->SELECTquery($fieldSQL,$table,$clauseSQL,'','tstamp DESC',$limitSQL);
			}
			$result = tx_div::db()->exec_SELECTquery($fieldSQL,$table,$clauseSQL,'','tstamp DESC',$limitSQL);

			/* PREPARE THE OUTPUT */
			if ($result) {
				while ($row = tx_div::db()->sql_fetch_assoc($result)) {

					// Handle the link
					$linkItem = isset($config['linkItem']) ? $config['linkItem'].' ' : 1;

					$url = '';
					if ($linkItem == 'true' || $linkItem == 1) {
						$link->destination($row['pid']);
						if (isset($this->controller->configurations['profileAjaxType'])) {
							$link->parameters(array('type' => $this->controller->configurations['profileAjaxType']));
						}
						$url = 'http://'.$this['host'].'/'.$link->makeUrl(false);
					}

					// Handle the default text
					$defaultText = isset($config['defaultText']) ? $config['defaultText'].' ' : '';

					// Handle the index of the array
					$uid = $row['uid'];
					if (strlen($uid) < 5) {
						$uid = str_pad($uid,5,'0');
					} else {
						$uid = substr($uid,0,5);
					}

					$entries[$row['updated'].$uid] = array(
						'title' => $defaultText.$row['title'],
						'updated' => $row['updated'],
						'published' => $row['published'],
						'summary' => $row['summary'],
						'link' => $url
					);
				}
			}
			// Sort decreasingly in case it is an union of different arrays
			krsort($entries,SORT_NUMERIC);
		}
		$this['entries'] = array_splice($entries,0,$limitSQL);
	}

	/**
	 * Return the list of page's pid being descendant of <code>$pid</code>.
	 *
	 * @param	integer		$pid: mother page's pid
	 * @param	array		$arrayOfPid: referenced array of children's pid
	 * @access	private
	 * @return	array		Array of all pid being children of <code>$pid</code>
	 */
	function getAllPages($pid, &$arrayOfPid = array()) {
		$pages = tx_div::db()->exec_SELECTgetRows('uid','pages','deleted = 0 AND hidden = 0 AND pid='.$pid);
		$arrayOfPid = array_merge($pages,$arrayOfPid);
		if (count($pages) > 0) {
			foreach ($pages as $page) {
				$this->getAllPages($page['uid'],$arrayOfPid);
			}
		}
		return $arrayOfPid;
	}
}
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ecorss/models/class.tx_ecorss_models_feed.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ecorss/models/class.tx_ecorss_models_feed.php']);
}
?>
