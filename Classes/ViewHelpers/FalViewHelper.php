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
 *	renders fal elements
 */
class Tx_Contentelements_ViewHelpers_FalViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\ImageViewHelper {
	
	/**
	 * file repository
	 * 
	 * @var \TYPO3\CMS\Core\Resource\FileRepository
	 * @inject
	 */
	protected $fileRepository;
	
	/**
	 * Initialize arguments.
	 *
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->overrideArgument('alt', 'string', 'Specifies an alternate text for an image', FALSE);
	}
	
	/**
	 * Returns the file 
	 *
	 * @return FileReference|boolean
	 */
	public function getFile() {
	
		// Get the UID from the current image object.
		$objectUid = $this->getUid();
	
		// Use the UID to search sys_file_reference
		$row = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('uid',
				'sys_file_reference', "uid_foreign={$objectUid} AND fieldname = 'file'
				AND tablenames = 'tt_content' AND deleted=0 AND hidden=0");
		
		if (is_array($row)) {
			$fileObject = $this->fileRepository->findFileReferenceByUid($row['uid']);
			//\TYPO3\CMS\Core\Utility\DebugUtility::debug($fileObject);
			return $fileObject;
		}
		return FALSE;
	}
	
	/**
	 * 
	 * @return integer $uid
	 */
	public function getUid() {
		if ($this->templateVariableContainer->exists("contentObjectData")) {
			// this works for templates but not for partials
			$contentObjectData = $this->templateVariableContainer->get("contentObjectData");
			$uid = $contentObjectData['uid'];
		} else {
			// this should work in every circumstance
			$cObj = $this->configurationManager->getContentObject();
			$uid = $cObj->data['uid'];
		}
		return $uid;
	}
	
	/**
	 * Resizes a given image (if required) and renders the respective img tag
	 *
	 * @see http://typo3.org/documentation/document-library/references/doc_core_tsref/4.2.0/view/1/5/#id4164427
	 * @param string $src
	 * @param string $width width of the image. This can be a numeric value representing the fixed width of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
	 * @param string $height height of the image. This can be a numeric value representing the fixed height of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
	 * @param integer $minWidth minimum width of the image
	 * @param integer $minHeight minimum height of the image
	 * @param integer $maxWidth maximum width of the image
	 * @param integer $maxHeight maximum height of the image
	 * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
	 * @return string rendered tag.
	 */
	public function render($src, $width = NULL, $height = NULL, $minWidth = NULL, $minHeight = NULL, $maxWidth = NULL, $maxHeight = NULL) {
		if (TYPO3_MODE === 'BE') {
			$this->simulateFrontendEnvironment();
		}
		$setup = array(
				'width' => $width,
				'height' => $height,
				'minW' => $minWidth,
				'minH' => $minHeight,
				'maxW' => $maxWidth,
				'maxH' => $maxHeight
		);
		
		$falImage = $this->getFile();
		if(is_object($falImage)) {
			//\TYPO3\CMS\Core\Utility\DebugUtility::debug($falImage->toArray());
			$src = $falImage->getPublicUrl();
		}
		
		if (TYPO3_MODE === 'BE' && substr($src, 0, 3) === '../') {
			$src = substr($src, 3);
		}
		
		$imageInfo = $this->contentObject->getImgResource($src, $setup);
		$GLOBALS['TSFE']->lastImageInfo = $imageInfo;
		if (!is_array($imageInfo)) {
			if (TYPO3_MODE === 'BE') {
				$this->resetFrontendEnvironment();
			}
			throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception('Could not get image resource for "' . htmlspecialchars($src) . '".', 1253191060);
		}
		$imageInfo[3] = \TYPO3\CMS\Core\Utility\GeneralUtility::png_to_gif_by_imagemagick($imageInfo[3]);
		$GLOBALS['TSFE']->imagesOnPage[] = $imageInfo[3];
		$imageSource = $GLOBALS['TSFE']->absRefPrefix . \TYPO3\CMS\Core\Utility\GeneralUtility::rawUrlEncodeFP($imageInfo[3]);
		if (TYPO3_MODE === 'BE') {
			$imageSource = '../' . $imageSource;
			$this->resetFrontendEnvironment();
		}
		$this->tag->addAttribute('src', $imageSource);
		$this->tag->addAttribute('width', $imageInfo[0]);
		$this->tag->addAttribute('height', $imageInfo[1]);
		//the alt-attribute is mandatory to have valid html-code, therefore add it even if it is empty
		if (empty($this->arguments['alt'])) {
			$this->tag->addAttribute('alt', $falImage->getTitle());
		}
		if (empty($this->arguments['title']) && !empty($this->arguments['alt'])) {
			$this->tag->addAttribute('title', $this->arguments['alt']);
		}
		return $this->tag->render();
	}
}
?>