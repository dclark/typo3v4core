<?php
/* $Id$ */

if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['tx_reports_tasks_SystemStatusUpdateTask'] = array(
	'extension'   => $_EXTKEY,
	'title'       => 'LLL:EXT:' . $_EXTKEY . '/reports/locallang.xml:status_updateTaskTitle',
	'description' => 'LLL:EXT:' . $_EXTKEY . '/reports/locallang.xml:status_updateTaskDescription'
);

$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_befunc.php']['displayWarningMessages']['tx_reports_WarningMessagePostProcessor'] = 'EXT:reports/reports/status/class.tx_reports_reports_status_warningmessagepostprocessor.php:tx_reports_reports_status_WarningMessagePostProcessor';

?>