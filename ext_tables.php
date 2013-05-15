<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// Adding title tag field to pages TCA
$tmpCol = array(
		'dimensions' => array(
				'exclude' => 1,
				'label' => 'LLL:EXT:contentelements/Resources/Private/Language/locallang_db.xml:tt_products.dimensions',
				'config' => Array (
						'type' => 'input',
						'size' => '70',
						'max' => '70',
						'eval' => 'trim'
				)
		),
		'approval' => array(
				'exclude' => 1,
				'label' => 'LLL:EXT:contentelements/Resources/Private/Language/locallang_db.xml:tt_products.approval',
				'config' => Array (
						'type' => 'input',
						'size' => '70',
						'max' => '70',
						'eval' => 'trim'
				)
		)
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_products', $tmpCol, 1);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_products', 'approval', '', 'after:note2');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_products', 'dimensions', '', 'after:note2');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'contentelements');

?>