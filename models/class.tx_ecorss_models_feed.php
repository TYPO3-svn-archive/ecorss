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
 * @author	Fabien Udriot <fabien.udriot@ecodev.ch>
 * @package TYPO3
 * @subpackage ecorss
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 */

class tx_ecorss_models_feed extends tx_lib_processor {

	/**
	 * Check if an email address exists in the database
	 *
	 * @return boolean
	 */
	public function load(){
		//init a few variables
		$configurations = is_array($this->controller->configurations['select.']) ? $this->controller->configurations['select.'] : array(0);
		$limitSQL = isset($this->controller->configurations['numberItems']) ? $this->controller->configurations['numberItems'] : '10';
		$entries = array();
		$linkClass = tx_div::makeInstance('tx_lib_link');

		$className = tx_div::makeInstance('tx_lib_link');
		$link = new $className();
		$link->noHash();

		foreach($configurations as $config){

			//init some variables
			$summary = $title = '';

			/* PROCESS THE TITLE */
			if(isset($config['titleXPath'])){
				$flexFormField = $config['title'] != '' ? $config['title'] : 'pi_flexform';
				$title .= "EXTRACTVALUE(".$flexFormField.",'".$config['titleXPath']."')";
			}
			else{
				$title = isset($config['title']) ? $config['title'] : 'header';
			}

			/* PROCESS THE SUMMARY */
			if(isset($config['summaryXPath'])){
				$flexFormField = $config['summary'] != '' ? $config['summary'] : 'pi_flexform';
				$summary .= "EXTRACTVALUE(".$flexFormField.",'".$config['summaryXPath']."')";
			}
			else{
				$summary = isset($config['summary']) ? $config['summary'] : 'bodytext';
			}

			/* PROCESS THE OTHER FIELDS */
			$published = isset($config['published']) ? $config['published'] : 'tstamp';
			$updated = isset($config['updated']) ? $config['updated'] : 'tstamp';
			$uid = isset($config['uid']) ? $config['uid'] : 'uid';
				
			$pid = isset($config['pid']) ? $config['pid'] : 'pid';
			//todo check
			$fieldSQL = $pid.' as pid, '.$uid.' as uid, '.$title.' as title, '.$summary.' as summary, '.$published.' as published, '.$updated.' as updated';

			/*PROCESS THE CLAUSE */
			$clauseSQL = 'hidden=0 and deleted=0';
			//select some field according to the configuration
			if(isset($config['field']) && isset($config['value'])){
				$values = explode(',',$config['value']);
				foreach($values as $value){
					$clauseSQL .= ' AND '.$config['field'].'="'.trim($value).'"';
				}
			}
			//exclude some field according to the configuration
			if(isset($config['field']) && isset($config['exclude'])){
				$values = explode(',',$config['exclude']);
				foreach($values as $value){
					$clauseSQL .= ' AND '.$config['field'].'!="'.trim($value).'"';
				}
			}
			$table = $config['table'] != '' ? $config['table'] : 'tt_content';

			$debug = isset($config['debug']) ? $config['debug'] : 'false';
			if($debug == 'true' || $debug == 1){
				print tx_div::db()->SELECTquery($fieldSQL,$table,$clauseSQL,'','tstamp DESC',$limitSQL);
			}
			$result = tx_div::db()->exec_SELECTquery($fieldSQL,$table,$clauseSQL,'','tstamp DESC',$limitSQL);

			/* PREPARE THE OUTPUT */
			if($result){
				while ($row = tx_div::db()->sql_fetch_assoc($result)) {

					//handle the link
					$linkItem = isset($config['linkItem']) ? $config['linkItem'].' ' : 1;

					$url = '';
					if($linkItem == 'true' || $linkItem == 1){
						$link->destination($row['pid']);
						//$link->parameters(array('type' => $this->configurations['profileAjaxType']));
						$url = 'http://'.t3lib_div::getIndpEnv('HTTP_HOST').'/'.$link->makeUrl(false);
					}
						
					//handle the default text
					$defaultText = isset($config['defaultText']) ? $config['defaultText'].' ' : '';
						
					//handle the index of the array
					$uid = $row['uid'];
					if(strlen($uid) < 5){
						while(strlen($uid) < 5){
							$uid .= '0';
						}
					}
					else{
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
			//sort decreasingly in case it is an union of different arrays
			krsort($entries,SORT_NUMERIC);
		}
		//print_r($entries);
		$this['entries'] = array_splice($entries, 0,$limitSQL);

	}
}
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ecorss/models/class.tx_ecorss_models_feed.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ecorss/models/class.tx_ecorss_models_feed.php']);
}
?>
