<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2005 - 2010 Michael Miousse (michael.miousse@infoglobe.ca)
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
 ***************************************************************/
/**
 * This class provides Scheduler Additional Field plugin implementation.
 *
 * @author Dimitri König <dk@cabag.ch>
 * @author Michael Miousse <michael.miousse@infoglobe.ca>
 * @package TYPO3
 * @subpackage linkvalidator
 */
class tx_linkvalidator_tasks_ValidateAdditionalFieldProvider implements tx_scheduler_AdditionalFieldProvider {

	/**
	 * Render additional information fields within the scheduler backend.
	 *
	 * @param	array		$taksInfo: array information of task to return
	 * @param	task		$task: task object
	 * @param	tx_scheduler_Module		$schedulerModule: reference to the calling object (BE module of the Scheduler)
	 * @return	array		additional fields
	 * @see interfaces/tx_scheduler_AdditionalFieldProvider#getAdditionalFields($taskInfo, $task, $schedulerModule)
	 */
	public function getAdditionalFields(array &$taskInfo, $task, tx_scheduler_Module $schedulerModule) {
		$additionalFields = array();
		if (empty($taskInfo['configuration'])) {
			if ($schedulerModule->CMD == 'add') {
				$taskInfo['configuration'] = '';
			} elseif ($schedulerModule->CMD == 'edit') {
				$taskInfo['configuration'] = $task->configuration;
			} else {
				$taskInfo['configuration'] = $task->configuration;
			}
		}

		if (empty($taskInfo['depth'])) {
			if ($schedulerModule->CMD == 'add') {
				$taskInfo['depth'] = array();
			} elseif ($schedulerModule->CMD == 'edit') {
				$taskInfo['depth'] = $task->depth;
			} else {
				$taskInfo['depth'] = $task->depth;
			}
		}

		if (empty($taskInfo['page'])) {
			if ($schedulerModule->CMD == 'add') {
				$taskInfo['page'] = '';
			} elseif ($schedulerModule->CMD == 'edit') {
				$taskInfo['page'] = $task->page;
			} else {
				$taskInfo['page'] = $task->page;
			}
		}
		if (empty($taskInfo['email'])) {
			if ($schedulerModule->CMD == 'add') {
				$taskInfo['email'] = '';
			} elseif ($schedulerModule->CMD == 'edit') {
				$taskInfo['email'] = $task->email;
			} else {
				$taskInfo['email'] = $task->email;
			}
		}

		if (empty($taskInfo['emailonbrokenlinkonly'])) {
			if ($schedulerModule->CMD == 'add') {
				$taskInfo['emailonbrokenlinkonly'] = 1;
				$task->emailonbrokenlinkonly = 1;
			} elseif ($schedulerModule->CMD == 'edit') {
				$taskInfo['emailonbrokenlinkonly'] = $task->emailonbrokenlinkonly;
			} else {
				$taskInfo['emailonbrokenlinkonly'] = $task->emailonbrokenlinkonly;
			}
		}
		if (empty($taskInfo['emailfile'])) {
			if ($schedulerModule->CMD == 'add') {
				$taskInfo['emailfile'] = 'EXT:linkvalidator/res/mailtemplate.html';
			} elseif ($schedulerModule->CMD == 'edit') {
				$taskInfo['emailfile'] = $task->emailfile;
			} else {
				$taskInfo['emailfile'] = $task->emailfile;
			}
		}


		$fieldID = 'task_page';
		$fieldCode = '<input type="text" name="tx_scheduler[page]"  id="' . $fieldID . '" value="' . $taskInfo['page'] . '"/>';
		$label = $GLOBALS['LANG']->sL('LLL:EXT:linkvalidator/locallang.xml:tasks.validate.page');
		$label = t3lib_BEfunc::wrapInHelp('linkvalidator', $fieldID, $label);
		$additionalFields[$fieldID] = array(
			'code' => $fieldCode,
			'label' => $label
		);

			// input for depth
		$fieldID = 'task_depth';
		$fieldValueArray = array(
			'0' => $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xml:labels.depth_0'),
			'1' => $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xml:labels.depth_1'),
			'2' => $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xml:labels.depth_2'),
			'3' => $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xml:labels.depth_3'),
			'4' => $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xml:labels.depth_4'),
			'999' => $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xml:labels.depth_infi'),
		);
		$fieldCode = '<select name="tx_scheduler[depth]" id="' . $fieldID . '">';

		foreach ($fieldValueArray as $depth => $label) {
			$fieldCode .= "\t" . '<option value="' . $depth . '"' . (($depth == $taskInfo['depth']) ? ' selected="selected"' : '') . '>' . $label . '</option>';
		}

		$fieldCode .= '</select>';
		$label = $GLOBALS['LANG']->sL('LLL:EXT:linkvalidator/locallang.xml:tasks.validate.depth');
		$label = t3lib_BEfunc::wrapInHelp('linkvalidator', $fieldID, $label);
		$additionalFields[$fieldID] = array(
			'code' => $fieldCode,
			'label' => $label
		);

		$fieldID = 'task_configuration';
		$fieldCode = '<textarea  name="tx_scheduler[configuration]" id="' . $fieldID . '" >' . $taskInfo['configuration'] . '</textarea>';
		$label = $GLOBALS['LANG']->sL('LLL:EXT:linkvalidator/locallang.xml:tasks.validate.conf');
		$label = t3lib_BEfunc::wrapInHelp('linkvalidator', $fieldID, $label);
		$additionalFields[$fieldID] = array(
			'code' => $fieldCode,
			'label' => $label
		);

		$fieldID = 'task_email';
		$fieldCode = '<input type="text"  name="tx_scheduler[email]" id="' . $fieldID . '" value="' . $taskInfo['email'] . '" />';
		$label = $GLOBALS['LANG']->sL('LLL:EXT:linkvalidator/locallang.xml:tasks.validate.email');
		$label = t3lib_BEfunc::wrapInHelp('linkvalidator', $fieldID, $label);
		$additionalFields[$fieldID] = array(
			'code' => $fieldCode,
			'label' => $label
		);
		$fieldID = 'task_emailonbrokenlinkonly';
		$fieldCode = '<input type="checkbox"  name="tx_scheduler[emailonbrokenlinkonly]" id="' . $fieldID . '" ' . ($taskInfo['emailonbrokenlinkonly'] ? 'checked="checked"' : '') . ' />';
		$label = $GLOBALS['LANG']->sL('LLL:EXT:linkvalidator/locallang.xml:tasks.validate.emailonbrokenlinkonly');
		$label = t3lib_BEfunc::wrapInHelp('linkvalidator', $fieldID, $label);
		$additionalFields[$fieldID] = array(
			'code' => $fieldCode,
			'label' => $label
		);

		$fieldID = 'task_emailfile';
		$fieldCode = '<input type="text"  name="tx_scheduler[emailfile]" id="' . $fieldID . '" value="' . $taskInfo['emailfile'] . '" />';
		$label = $GLOBALS['LANG']->sL('LLL:EXT:linkvalidator/locallang.xml:tasks.validate.emailfile');
		$label = t3lib_BEfunc::wrapInHelp('linkvalidator', $fieldID, $label);
		$additionalFields[$fieldID] = array(
			'code' => $fieldCode,
			'label' => $label
		);

		return $additionalFields;
	}


	/**
	 * Mark current value as selected by returning the "selected" attribute.
	 *
	 * @param	array		$configurationArray: array of configuration
	 * @param	string		$currentValue: value of selector object
	 * @return	string		Html fragment for a selected option or empty
	 * @access protected
	 */
	protected function getSelectedState($configurationArray, $currentValue) {
		$selected = '';
		for ($i = 0; $i < count($configurationArray); $i++) {
			if (strcmp($configurationArray[$i], $currentValue) === 0) {
				$selected = 'selected="selected" ';
			}
		}
		return $selected;
	}


	/**
	 * This method checks any additional data that is relevant to the specific task.
	 * If the task class is not relevant, the method is expected to return TRUE.
	 *
	 * @param	array		$submittedData: reference to the array containing the data submitted by the user
	 * @param	tx_scheduler_module1		$parentObject: reference to the calling object (BE module of the Scheduler)
	 * @return	boolean		True if validation was ok (or selected class is not relevant), FALSE otherwise
	 */
	public function validateAdditionalFields(array &$submittedData, tx_scheduler_Module $schedulerModule) {
		$isValid = TRUE;

		//!TODO add validation to validate the $submittedData['configuration'] wich is normally a comma seperated string
		if (!empty($submittedData['email'])) {
			$emailList = t3lib_div::trimExplode(',', $submittedData['email']);
			foreach ($emailList as $emailAdd) {
				if (!t3lib_div::validEmail($emailAdd)) {
					$isValid = FALSE;
					$schedulerModule->addMessage(
						$GLOBALS['LANG']->sL('LLL:EXT:linkvalidator/locallang.xml:tasks.validate.invalidEmail'),
						t3lib_FlashMessage::ERROR
					);
				}
			}
		}

		if ($res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'pages', 'uid = ' . $submittedData['page'])) {
			if ($GLOBALS['TYPO3_DB']->sql_num_rows($res) == 0 && $submittedData['page'] > 0) {
				$isValid = FALSE;
				$schedulerModule->addMessage(
					$GLOBALS['LANG']->sL('LLL:EXT:linkvalidator/locallang.xml:tasks.validate.invalidPage'),
					t3lib_FlashMessage::ERROR
				);
			}
		} else {
			$isValid = FALSE;
			$schedulerModule->addMessage(
				$GLOBALS['LANG']->sL('LLL:EXT:linkvalidator/locallang.xml:tasks.validate.invalidPage'),
				t3lib_FlashMessage::ERROR
			);
		}

		if ($submittedData['depth'] < 0) {
			$isValid = FALSE;
			$schedulerModule->addMessage(
				$GLOBALS['LANG']->sL('LLL:EXT:linkvalidator/locallang.xml:tasks.validate.invalidDepth'),
				t3lib_FlashMessage::ERROR
			);
		}

		return $isValid;
	}


	/**
	 * This method is used to save any additional input into the current task object
	 * if the task class matches.
	 *
	 * @param	array		$submittedData: array containing the data submitted by the user
	 * @param	tx_scheduler_Task		$task: reference to the current task object
	 * @return	void
	 */
	public function saveAdditionalFields(array $submittedData, tx_scheduler_Task $task) {
		$task->depth = $submittedData['depth'];
		$task->page = $submittedData['page'];
		$task->email = $submittedData['email'];
		$task->emailonbrokenlinkonly = $submittedData['emailonbrokenlinkonly'];
		$task->configuration = $submittedData['configuration'];
		$task->emailfile = $submittedData['emailfile'];
	}


}

if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/linkvalidator/classes/tasks/class.tx_linkvalidator_tasks_validateadditionalfieldprovider.php'])) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/linkvalidator/classes/tasks/class.tx_linkvalidator_tasks_validateadditionalfieldprovider.php']);
}

?>