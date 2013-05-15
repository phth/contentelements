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
 *	tt_product hooks
 */
class tx_contentelements_hooks  {
	
	public function getItemMarkerArray (&$ref, &$markerArray, $cObjectMarkerArray, $item, $catTitle, $imageNum, $imageRenderObj, $forminfoArray, $theCode, $id, $linkWrap) {
		
		//debug($markerArray);
		//die();
		
		$record = t3lib_BEfunc::getRecord('tt_products',$item['rec']['uid']);
		
		$markerArray['###PRODUCT_DELIVERY_CLASS###'] = '';
		if($record['delivery'] == '0') {
			$markerArray['###PRODUCT_DELIVERY_CLASS###'] = 'delivery-demand';
		}
		if($record['delivery'] == '1') {
			$markerArray['###PRODUCT_DELIVERY_CLASS###'] = 'delivery-immediate';
		}
		
		$markerArray['###PRODUCT_DIMENSIONS###'] = $record['dimensions'];
		
		$markerArray['###PRODUCT_APPROVAL###'] = $record['approval'];
		
		$markerArray['"###PRODUCT_TITLE_TITLE###"'] = '';
		if(strlen($record['title']) > 15) {
			$markerArray['###PRODUCT_TITLE_TITLE###'] = $record['title'];
		}
		
		$markerArray['###PRODUCT_DIMENSIONS_TITLE###'] = '';
		if(strlen($record['dimensions']) > 20) {
			$markerArray['###PRODUCT_DIMENSIONS_TITLE###'] = $record['dimensions'];
			$markerArray['###PRODUCT_DIMENSIONS###'] = substr($record['dimensions'],0,17).'...';
		}
		
		$markerArray['###PRODUCT_APPROVAL_TITLE###'] = '';
		if(strlen($record['approval']) > 25) {
			$markerArray['###PRODUCT_APPROVAL_TITLE###'] = $record['approval'];
			$markerArray['###PRODUCT_APPROVAL###'] = substr($record['approval'],0,23).'...';
		}
	}
	
}

?>