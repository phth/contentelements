<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Classes/Hooks/class.tx_contentelements_hooks.php');
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tt_products']['PRODUCT'][] = 'tx_contentelements_hooks';

?>