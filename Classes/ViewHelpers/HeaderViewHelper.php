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
 *	renders standard content element header
 */
class Tx_Contentelements_ViewHelpers_HeaderViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
	
	/**
	 * @var Tx_Extbase_Configuration_ConfigurationManagerInterface
	 * @inject
	 */
	protected $configurationManager;
	
	/**
	 * Initialize arguments.
	 *
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();
	}
	
	/**
	 * renders the content element header
	 * 
	 * @return string $header
	 */
	public function render() {
		$header = '';
		
		if ($this->templateVariableContainer->exists("contentObjectData")) {
			// this works for templates but not for partials
			$contentObjectData = $this->templateVariableContainer->get("contentObjectData");
			$header = $contentObjectData->data['header'];
		} else {
			// this should work in every circumstance
			$contentObjectData = $this->configurationManager->getContentObject();
			$header = $contentObjectData->data['header'];
		}
		return $header;
	}
	
}
?>