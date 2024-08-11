<?php


if (Sys25\RnBase\Utility\Environment::isBackend()) {

	$_EXTKEY = 'imagemap_wizard';
	// Hier knallt der DI-Container weg. Das geht so nicht mehr.
//	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['GLOBAL']['softRefParser']['tx_imagemapwizard'] = "tx_imagemapwizard_softrefproc";

	//$GLOBALS['TBE_MODULES_EXT']['xMOD_db_new_content_el']['addElClasses']['tx_imagemapwizard_wizicon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'classes/class.tx_imagemapwizard_wizicon.php';

	$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][] = [
	    'nodeName' => 'sys25imagemap',
	    'priority' => 1,
	    'class' => \Sys25\ImageMapWizard\Form\ImageMapElement::class,
	];
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][] = [
	    'nodeName' => 'wizard_sys25imagemap',
	    'priority' => 1,
	    'class' => \Sys25\ImageMapWizard\Form\ImageMapWizardController::class,
	];
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][] = [
	    'nodeName' => 'popup_sys25imagemap',
	    'priority' => 1,
	    'class' => \Sys25\ImageMapWizard\Form\ImageMapPopup::class,
	];

}

	$typoscript = '
		includeLibs.imagemap_wizard = EXT:imagemap_wizard/classes/class.tx_imagemapwizard_parser.php
		tt_content.imagemap_wizard < tt_content.image
		tt_content.imagemap_wizard.20.imgMax = 1
		tt_content.imagemap_wizard.20.maxW >
		tt_content.imagemap_wizard.20.1.imageLinkWrap >
		tt_content.imagemap_wizard.20.1.params = usemap="#***IMAGEMAP_USEMAP***"
		tt_content.imagemap_wizard.20.1.stdWrap.postUserFunc = tx_imagemapwizard_parser->applyImageMap
		tt_content.imagemap_wizard.20.1.stdWrap.postUserFunc.map.data = field:tx_imagemapwizard_links
		tt_content.imagemap_wizard.20.1.stdWrap.postUserFunc.map.name = field:titleText // field:altText // field:imagecaption // field:header
		tt_content.imagemap_wizard.20.1.stdWrap.postUserFunc.map.name.crop = 20
		tt_content.imagemap_wizard.20.1.stdWrap.postUserFunc.map.name.case = lower
	';

	$imwizardConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['imagemap_wizard'] ?? '');
	if($imwizardConf['allTTCtypes'] ?? false) {
		$typoscript .= '
			tt_content.imagemap_wizard.20.imgMax >
			tt_content.image.20 < tt_content.imagemap_wizard.20
			tt_content.imagemap_wizard.20.imgMax = 1
		';
	}

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY,'setup',$typoscript,'defaultContentRendering');

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
		mod.wizards.newContentElement.wizardItems.common.elements.imagemap {
			icon = EXT:imagemap_wizard/tt_content_imagemap.gif
			title = LLL:EXT:imagemap_wizard/locallang.xml:imagemap.title
			description = LLL:EXT:imagemap_wizard/locallang.xml:imagemap.description
			tt_content_defValues {
				CType = imagemap_wizard
			}
		}
		mod.wizards.newContentElement.wizardItems.common.show := addToList(imagemap)

		templavoila.wizards.newContentElement.wizardItems.common.elements.imagemap {
			icon = EXT:imagemap_wizard/tt_content_imagemap.gif
			title = LLL:EXT:imagemap_wizard/locallang.xml:imagemap.title
			description = LLL:EXT:imagemap_wizard/locallang.xml:imagemap.description
			tt_content_defValues {
				CType = imagemap_wizard
			}
		}
		templavoila.wizards.newContentElement.wizardItems.common.show := addToList(imagemap)
	');
