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
 * FAL FlexForm field ViewHelper
 *
 * @package Contentelements
 * @subpackage ViewHelpers/Flexform/Field
 */
class Tx_Contentelements_ViewHelpers_Flexform_Field_FalViewHelper extends Tx_Flux_ViewHelpers_Flexform_Field_GroupViewHelper {

	/**
	 * Initialize
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->overrideArgument('internalType', 'string', 'FlexForm-internalType of this Group Selector', FALSE, 'file');
			// TODO: after removing this next argument from the GroupViewHelper, change this to registerArgument()
		$this->overrideArgument('uploadFolder', 'string', 'Upload folder. DEPRECATED, will be moved to the File field ViewHelper');
	}

	/**
	 * Render method
	 * @return void
	 */
	public function render() {
		$config = $this->getFieldConfig();
		$config = array_merge(
			$config,
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'file',
				array(
						'appearance' => array(
								'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference',
								'collapseAll' => TRUE,
						),
						'maxitems' => 1,
						'minitems' => 1
				),
				$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			)
			
		);
		$this->addField($config);
	}

}
