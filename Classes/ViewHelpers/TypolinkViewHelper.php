<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Philipp Thiele <philipp.thiele@phth.de>, PHTH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 *****************************************************************/
 
/**
 *	Wraps some of the basic Typolink settings in a viewhelper. Good for rendering links to pages and page titles
 *	when all you have is the page id.
 */
class Tx_Contentelements_ViewHelpers_TypolinkViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
	/**
	 * @param string $parameter
	 * @param string $target
	 * @param int $noCache
	 * @param int $useCacheHash
	 * @param array $additionalParams
	 * @param string $ATagParams
	 * @param string $returnLast
	 * @return mixed
	 */
	public function render($parameter, $target='',$noCache=0,$useCacheHash=1,$additionalParams=array(),$ATagParams = '',$returnLast = '') {
		$typoLinkConf = array(
			'parameter' => $parameter,
		);
 
		if($target) {
			$typoLinkConf['target'] = $target;
		}
 
		if($noCache) {
			$typoLinkConf['no_cache'] = 1;
		}
 
		if($useCacheHash) {
			$typoLinkConf['useCacheHash'] = 1;
		}
 
		if(count($additionalParams)) {
			$typoLinkConf['additionalParams'] = \TYPO3\CMS\Core\Utility\GeneralUtility::implodeArrayForUrl('',$additionalParams);
		}
 
		if(strlen($ATagParams)) {
			$typoLinkConf['ATagParams'] = $ATagParams;
		}
		
		if(strlen($returnLast)) {
			$typoLinkConf['returnLast'] = $returnLast;
		}
 
		$linkText = $this->renderChildren();
 
		$textContentConf = array(
			'typolink.' => $typoLinkConf,
			'value' => $linkText
		);
		
		return $GLOBALS['TSFE']->cObj->cObjGetSingle('TEXT',$textContentConf);
	}
}
?>