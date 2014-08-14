<?php

$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][] = array(
    0 => 'LLL:EXT:imagemap_wizard/locallang.xml:imagemap.title',
    1 => 'imagemap_wizard',
    2 => 'i/tt_content_image.gif',
);

$tempColumns = array (
	'tx_imagemapwizard_links' => array(
		'label' => 'LLL:EXT:imagemap_wizard/locallang.xml:tt_content.tx_imagemapwizard_links',
		'config' => array (
			'type' => 'user',
			'userFunc' => 'tx_imagemapwizard_controller_wizard->renderForm',
			'wizards' => array(
				'imagemap' => array(
					'type' => 'popup',
					'script' => 'EXT:imagemap_wizard/wizard.php',
					'title' => 'ImageMap',
					'JSopenParams' => 'height=700,width=780,status=0,menubar=0,scrollbars=1',
					'icon' => 'link_popup.gif',
				),
				'_VALIGN' => 'middle',
				'_PADDING' => '4',
			),
			'softref'=>'tx_imagemapwizard',
		),
	),
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns("tt_content",$tempColumns,1);

$imwizardConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['imagemap_wizard']);

$GLOBALS['TCA']['tt_content']['types']['imagemap_wizard'] = $GLOBALS['TCA']['tt_content']['types']['image'];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content','tx_imagemapwizard_links', ($imwizardConf['allTTCtypes'] ? '' : 'imagemap_wizard') ,'after:image');
// CSH context sensitive help
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tt_content','EXT:imagemap_wizard/locallang_csh_ttc.xml');

if (TYPO3_MODE=='BE')    {
    $GLOBALS['TBE_MODULES_EXT']['xMOD_db_new_content_el']['addElClasses']['tx_imagemapwizard_wizicon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'classes/class.tx_imagemapwizard_wizicon.php';
}

$icons = array(
	'redo' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'res/arrow_redo.png',
	'link' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'res/link_edit.png',
	'zoomin' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'res/magnifier_zoom_in.png',
	'zoomout' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'res/magnifier_zoom_out.png',
);
\TYPO3\CMS\Backend\Sprite\SpriteManager::addSingleIcons($icons, $_EXTKEY);

?>