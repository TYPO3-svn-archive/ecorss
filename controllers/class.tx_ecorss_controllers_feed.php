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

class tx_ecorss_controllers_feed extends tx_lib_controller{

	var $defaultAction = 'default';
	
	public function add($content,$configurations) {
		$htmlHeader = '';
		$errorMsg = '<div style="color:red"><b>plugin ecorss error</b> : ';
		//loop around the feed
		foreach($configurations as $config){
			if(is_array($config)){
				
				if(isset($config['typeNum'])){
					$title = isset($config['title']) ? $config['title'] : '';
					$feed = isset($config['feed']) ? $config['feed'] : 'atom';
					switch($feed){
						case 'rss' :
							$feed = 'application/rss+xml';
							break;
						case 'atom' :
						default :
							$feed = 'application/atom+xml';
					}
					$htmlHeader .= '<link rel="alternate" type="'.$feed.'" title="'.$title.'" href="'.$config['url'].'" />'.chr(10); 
				}
				else{
					print $errorMsg.'parameter typeNum is missing in TypoScript. Try something like this in setup : page.headerData.xxx.myFeed.typeNum = yyy'.'</div>';
				}
			}
		}
		$GLOBALS['TSFE']->additionalHeaderData[$this->getClassName()] = $htmlHeader;
		
		/*
		 * feed example :
		 * http://www.oreillynet.com/pub/feed/20 (atom)
		 * http://www.oreillynet.com/pub/feed/20?format=rss1
		 * http://www.oreillynet.com/pub/feed/20?format=rss2
		 */
	}

	public function display($content,$configurations) {
		$ClassName = tx_div::makeInstance('tx_ecorss_controllers_feed');
		$feed = new $ClassName();
		$TSconfig = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_ecorss.']['controller.']['feed.'];
		$TSconfig['configurations.'] = array_merge($TSconfig['configurations.'],$configurations);
		return $feed->main(null,$TSconfig);
		
		// !!! TODO, will probably change in future lib/div 
		// evaluate this :
		//$ClassName = tx_div::makeInstance('tx_ecorss_controllers_feed');
		//$class = new $ClassName();
		//$TSconfig = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_ecorss.']['setup.'];
		//return $class->main(null, array_merge($TSconfig['configurations.'],$configurations));
	}
	
	public function defaultAction() {
		// finding classnames
		$model = $this->makeInstance('tx_ecorss_models_feed');
		$model['title'] = $this->configurations['title'];
		$model['subtitle'] = $this->configurations['subtitle'];
		$model['lang'] = isset($this->configurations['lang']) ? $this->configurations['lang'] : 'en-GB';
		$model['host'] = isset($this->configurations['host']) ? $this->configurations['host'] : t3lib_div::getIndpEnv('HTTP_HOST');
		$model['url'] = t3lib_div::getIndpEnv('REQUEST_URI');
		$model->load();
		
		//... and the view
		$view = $this->makeInstance('tx_ecorss_views_feed',$model);
		$this->castList('entries','tx_ecorss_views_feed','tx_ecorss_views_feed',TRUE,TRUE,$view);
//		$view->castElements('tx_ecorss_views_entry');
		
		switch($this->configurations['feed']){
			case 'rss';
				$template = 'rssTemplate';
				break;
			case 'atom';
			default ;
				$template = 'atomTemplate';
		}

		$encoding = isset($this->configurations['encoding']) ? $this->configurations['encoding'] : 'utf-8';
		$output = '<?xml version="1.0" encoding="'.$encoding.'"?>'.chr(10);
		return $output.$view->render($template);
	}
	
	//Temporary function. This function has been removed from lib 0.0.24 from tx_lib_object. Waiting for a solution in a next "stable" alpha release.
	function castList($key, $listClassName = 'tx_lib_object', $listEntryClassName = 'tx_lib_object', $callMakeInstanceClassNameForList = TRUE, $callMakeInstanceClasNameForListEntry = TRUE,&$object) {
		if($callMakeInstanceClasNameForList) $listClassName = tx_div::makeInstanceClassName($listClassName);
		if($callMakeInstanceClasNameForListEntry) $listEntryClassName = tx_div::makeInstanceClassName($listEntryClassName);
		// First type the array or object to the new list object, so that we are sure to have an iterator object.
		$list = new $listClassName($object->controller, $object->get($key)); 
		for($list->rewind(); $list->valid(); $list->next()) 
			$list->set($list->key(), new $listEntryClassName($object->controller, tx_div::toHashArray($list->current()))); 
		$object->set($key, $list);
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ecorss/controllers/class.tx_ecorss_controllers_feed.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ecorss/controllers/class.tx_ecorss_controllers_feed.php']);
}
?>
