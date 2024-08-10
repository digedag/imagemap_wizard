<?php

$_EXTKEY = 'imagemap_wizard';

if (TYPO3_MODE=='BE')    {
    $GLOBALS['TBE_MODULES_EXT']['xMOD_db_new_content_el']['addElClasses']['tx_imagemapwizard_wizicon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Classes/class.tx_imagemapwizard_wizicon.php';
}

$icons = [
	'redo' => 'EXT:imagemap_wizard/res/arrow_redo.png',
	'link' => 'EXT:imagemap_wizard/res/link_edit.png',
	'zoomin' => 'EXT:imagemap_wizard/res/magnifier_zoom_in.png',
	'zoomout' => 'EXT:imagemap_wizard/res/magnifier_zoom_out.png',
];


$iconRegistry = \tx_rnbase::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
foreach ($icons as $iconId => $iconSource) {
    $iconRegistry->registerIcon(
        $iconId,
        \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
        ['source' => $iconSource]
    );
}



