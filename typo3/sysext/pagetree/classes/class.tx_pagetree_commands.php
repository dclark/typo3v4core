<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 TYPO3 Tree Team <http://forge.typo3.org/projects/typo3v4-extjstrees>
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
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Page Tree and Context Menu Commands
 *
 * @author Stefan Galinski <stefan.galinski@gmail.com>
 * @package TYPO3
 * @subpackage tx_pagetree
 */
final class tx_pagetree_Commands {
	/**
	 * Visibly the page
	 *
	 * @param tx_pagetree_Node $nodeData
	 * @return void
	 */
	public static function visiblyNode(tx_pagetree_Node $node) {
		$data['pages'][$node->getWorkspaceId()]['hidden'] = 0;
		self::processTceCmdAndDataMap(array(), $data);
	}

	/**
	 * Hide the page
	 *
	 * @param tx_pagetree_Node $nodeData
	 * @return void
	 */
	public static function disableNode(tx_pagetree_Node $node) {
		$data['pages'][$node->getWorkspaceId()]['hidden'] = 1;
		self::processTceCmdAndDataMap(array(), $data);
	}

	/**
	 * Delete the page
	 *
	 * @param tx_pagetree_Node $nodeData
	 * @return void
	 */
	public static function deleteNode(tx_pagetree_Node $node) {
		$cmd['pages'][$node->getId()]['delete'] = 1;
		self::processTceCmdAndDataMap($cmd);
	}

	/**
	 * Restore the page
	 *
	 * @param tx_pagetree_Node $nodeData
	 * @param int $targetId
	 * @return void
	 */
	public static function restoreNode(tx_pagetree_Node $node, $targetId) {
		$cmd['pages'][$node->getId()]['undelete'] = 1;
		self::processTceCmdAndDataMap($cmd);

		if ($node->getId() !== $targetId) {
			self::moveNode($node, $targetId);
		}
	}

	/**
	 * Updates the node label
	 *
	 * @param tx_pagetree_Node $nodeData
	 * @param string $updatedLabel
	 * @return void
	 */
	public static function updateNodeLabel(tx_pagetree_Node $node, $updatedLabel) {
		$data['pages'][$node->getWorkspaceId()][$node->getTextSourceField()] = $updatedLabel;
		self::processTceCmdAndDataMap(array(), $data);
	}

	/**
	 * Copies a page and returns the id of the new page
	 *
	 * Node: Use a negative target id to specify a sibling target else the parent is used
	 *
	 * @param tx_pagetree_Node $sourceNode
	 * @param int $targetId
	 * @return int
	 */
	public static function copyNode(tx_pagetree_Node $sourceNode, $targetId) {
		$cmd['pages'][$sourceNode->getId()]['copy'] = $targetId;
		$returnValue = self::processTceCmdAndDataMap($cmd);

		return $returnValue['pages'][$sourceNode->getId()];
	}

	/**
	 * Moves a page
	 *
	 * Node: Use a negative target id to specify a sibling target else the parent is used
	 *
	 * @param tx_pagetree_Node $sourceNode
	 * @param int $targetId
	 * @return void
	 */
	public static function moveNode(tx_pagetree_Node $sourceNode, $targetId) {
		$cmd['pages'][$sourceNode->getId()]['move'] = $targetId;
		self::processTceCmdAndDataMap($cmd);
	}

	/**
	 * Creates a page of the given doktype and returns the id of the created page
	 *
	 * @param tx_pagetree_Node $parentNode
	 * @param int $targetId
	 * @param int $pageType
	 * @return int
	 */
	public static function createNode(tx_pagetree_Node $parentNode, $targetId, $pageType) {
		$placeholder = 'NEW12345';
		$data['pages'][$placeholder] = array(
			'pid' => $parentNode->getWorkspaceId(),
			'doktype' => $pageType,
			'title' => $GLOBALS['LANG']->sL('LLL:EXT:pagetree/locallang_pagetree.xml:defaultTitle', TRUE),
		);
		$newPageId = self::processTceCmdAndDataMap(array(), $data);
		$node = self::getNode($newPageId[$placeholder]);

		if ($parentNode->getWorkspaceId() !== $targetId) {
			self::moveNode($node, $targetId);
		}

		return $newPageId[$placeholder];
	}

	/**
	 * Process TCEMAIN commands and data maps
	 *
	 * Command Map:
	 * Used for moving, recover, remove and some more operations.
	 *
	 * Data Map:
	 * Used for creating and updating records,
	 *
	 * This API contains all necessary access checks.
	 *
	 * @param array $cmd
	 * @param array $data
	 * @throws Exception if an error happened while the TCE processing
	 * @return array
	 */
	protected static function processTceCmdAndDataMap(array $cmd, array $data = array()) {
		/** @var $tce t3lib_TCEmain */
		$tce = t3lib_div::makeInstance('t3lib_TCEmain');
		$tce->stripslashes_values = 0;
		$tce->start($data, $cmd);
		$tce->copyTree = t3lib_div::intInRange($GLOBALS['BE_USER']->uc['copyLevels'], 0, 100);

		if (count($cmd)) {
			$tce->process_cmdmap();
			$returnValues = $tce->copyMappingArray_merged;
		} elseif (count($data)) {
			$tce->process_datamap();
			$returnValues = $tce->substNEWwithIDs;
		}

			// check errors
		if (count($tce->errorLog)) {
			throw new Exception(implode(chr(10), $tce->errorLog));
		}

		return $returnValues;
	}

	/**
	 * Returns a node from the given node id
	 *
	 * @param int $nodeId
	 * @param boolean $unsetMovePointers
	 * @return tx_pagetree_Node
	 */
	public static function getNode($nodeId, $unsetMovePointers = TRUE) {
		$record = self::getNodeRecord($nodeId, $unsetMovePointers);
		return self::getNewNode($record);
	}

	/**
	 * Returns the mount point path
	 *
	 * @static
	 * @return void
	 */
	public static function getMountPointPath() {
		$temporaryMountPoint = intval($GLOBALS['BE_USER']->uc['pageTree_temporaryMountPoint']);
		if (!$temporaryMountPoint) {
			return '';
		}

		$useNavTitle = $GLOBALS['BE_USER']->getTSConfigVal('options.pageTree.showNavTitle');
		$rootline = array_reverse(t3lib_BEfunc::BEgetRootLine($temporaryMountPoint));
		array_shift($rootline);

		$path = array();
		foreach ($rootline as $rootlineElement) {
			$record = tx_pagetree_Commands::getNodeRecord($rootlineElement['uid']);

			$text = $record['title'];
			if ($useNavTitle && trim($record['nav_title']) !== '') {
				$text = $record['nav_title'];
			}

			$path[] = $text;
		}

		return '/' . implode('/', $path);
	}

	/**
	 * Returns a node record from a given id
	 *
	 * @param int $nodeId
	 * @param boolean $unsetMovePointers
	 * @return array
	 */
	public static function getNodeRecord($nodeId, $unsetMovePointers = TRUE) {
		$record = t3lib_BEfunc::getRecordWSOL('pages', $nodeId, '*', '', TRUE, $unsetMovePointers);
		return $record;
	}

	/**
	 * Returns the first configured domain name for a page
	 *
	 * @static
	 * @param integer $uid
	 * @return string
	 */
	public static function getDomainName($uid) {
		$whereClause = $GLOBALS['TYPO3_DB']->quoteStr(
			'pid=' . intval($uid) . t3lib_BEfunc::deleteClause('sys_domain') .
				t3lib_BEfunc::BEenableFields('sys_domain'),
			'sys_domain'
		);

		$domain = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow(
			'domainName',
			'sys_domain',
			$whereClause,
			'',
			'sorting'
		);

		return htmlspecialchars($domain['domainName']);
	}

	/**
	 * Creates a node with the given record information's
	 *
	 * @param array $record
	 * @return tx_pagetree_Node
	 */
	public static function getNewNode($record, $mountPoint = 0) {
		$useNavTitle = $GLOBALS['BE_USER']->getTSConfigVal('options.pageTree.showNavTitle');
		$addIdAsPrefix = $GLOBALS['BE_USER']->getTSConfigVal('options.pageTree.showPageIdWithTitle');
		$addDomainName = $GLOBALS['BE_USER']->getTSConfigVal('options.pageTree.showDomainNameWithTitle');

		/** @var $subNode tx_pagetree_Node */
		$subNode = t3lib_div::makeInstance('tx_pagetree_Node');
		$subNode->setRecord($record);
		$subNode->setCls($record['_CSSCLASS']);
		$subNode->setQTip('ID: ' . $record['uid']);
		$subNode->setType('pages');

		$subNode->setId($record['uid']);
		$subNode->setMountPoint($mountPoint);
		$subNode->setWorkspaceId(($record['_ORIG_uid'] ? $record['_ORIG_uid'] : $record['uid']));

		$field = 'title';
		$text = $record['title'];
		if ($useNavTitle && trim($record['nav_title']) !== '') {
			$field = 'nav_title';
			$text = $record['nav_title'];
		}

		$suffix = '';
		if ($addDomainName) {
			$domain = self::getDomainName($record['uid']);
			$suffix = ($domain !== '' ? ' [' . $domain . ']' : '');
		}

		$prefix = ($addIdAsPrefix ? '[' . $record['uid'] . '] ' : '');
		$subNode->setText($text, $field, $prefix, $suffix);
		$subNode->setEditableText($text);

		if ($record['uid'] !== 0) {
			$spriteIconCode = t3lib_iconWorks::getSpriteIconForRecord('pages', $record);
		} else {
			$spriteIconCode = t3lib_iconWorks::getSpriteIcon('apps-pagetree-root');
		}
		$subNode->setSpriteIconCode($spriteIconCode);

		if (!$subNode->canCreateNewPages() || intval($record['t3ver_state']) === 2) {
			$subNode->setIsDropTarget(FALSE);
		}

		if (!$subNode->canBeEdited() || !$subNode->canBeRemoved() || intval($record['t3ver_state']) === 2) {
			$subNode->setDraggable(FALSE);
		}

		return $subNode;
	}
}

?>