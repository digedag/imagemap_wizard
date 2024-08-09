<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2008 Tolleiv Nietsch (info@tolleiv.de)
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

class tx_imagemapwizard_wizicon {

	/**
	 * Adds wizard icon
	 *
	 * @param   array	  $wizardItems Input array with wizard items for plugins
	 * @return   array	  Modified input array, having the item added.
	 */
	function proc($wizardItems) {

		$LL = $this->includeLocalLang();

		$newWizardItem['common_imagemap'] = array(
			'icon' => 'EXT:imagemap_wizard/tt_content_imagemap.gif',
			'title' => $GLOBALS['LANG']->getLLL('imagemap.title', $LL),
			'description' => $GLOBALS['LANG']->getLLL('imagemap.description', $LL),
			'tt_content_defValues.' => array(
				'CType' => 'imagemap_wizard'
			)
		);

		$specialPart = is_array($wizardItems) ? $wizardItems : array();
		$commonPart = array_splice($specialPart, 0, $this->getCommonItemCount($wizardItems));

		return array_merge($commonPart, $newWizardItem, $specialPart);
	}

	/**
	 * @param $list
	 * @return int
	 */
	function getCommonItemCount($list) {
		if (!is_array($list)) {
			return FALSE;
		}
		reset($list);
		$num = 0;
		while (preg_match('/^common/', key($list)) && next($list)) {
			$num++;
		}
		return $num;
	}


	/**
	 * Includes the locallang file
	 *
	 * @return array	The LOCAL_LANG array
	 */
	function includeLocalLang() {
		$llFile = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('imagemap_wizard') . 'locallang.xml';
		/** @var $localizationParser TYPO3\CMS\Core\Localization\Parser\LocallangXmlParser */
		$localizationParser = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Localization\Parser\LocallangXmlParser');
		$LOCAL_LANG = $localizationParser->getParsedData($llFile, $GLOBALS['LANG']->lang);
		return $LOCAL_LANG;
	}
}
