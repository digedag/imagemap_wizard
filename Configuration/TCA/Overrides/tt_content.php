<?php
if (! defined ( 'TYPO3_MODE' )) die ( 'Access denied.' );

$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][] = array(
    0 => 'LLL:EXT:imagemap_wizard/locallang.xml:imagemap.title',
    1 => 'imagemap_wizard',
    2 => 'i/tt_content_image.gif',
);

$tempColumns = array (
    'tx_imagemapwizard_links' => array(
        'label' => 'LLL:EXT:imagemap_wizard/locallang.xml:tt_content.tx_imagemapwizard_links',
        'config' => [
            'type' => 'sys25imagemap',
//            'userFunc' => 'tx_imagemapwizard_controller_wizard->renderForm',
//             'fieldWizard' => [
//                 'sys25imagemap' => [
//                     'type' => 'popup',
//                     'module' => array(
//                         'name' => 'wizard_sys25imagemap',
//                     ),
// //                    'script' => 'EXT:imagemap_wizard/wizard.php',
//                     'title' => 'ImageMap',
//                     'JSopenParams' => 'height=700,width=780,status=0,menubar=0,scrollbars=1',
//                     'icon' => 'link_popup.gif',
//                 ],
//                 '_VALIGN' => 'middle',
//                 '_PADDING' => '4',
//             ],
            'softref'=>'tx_imagemapwizard',
        ],
    ),
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns("tt_content",$tempColumns,1);

$imwizardConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['imagemap_wizard'] ?? '');

$GLOBALS['TCA']['tt_content']['types']['imagemap_wizard'] = $GLOBALS['TCA']['tt_content']['types']['image'];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    'tx_imagemapwizard_links', 
    (($imwizardConf['allTTCtypes'] ?? false) ? '' : 'imagemap_wizard'),
    'after:image'
);
// CSH context sensitive help
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    'tt_content',
    'EXT:imagemap_wizard/locallang_csh_ttc.xml'
);


