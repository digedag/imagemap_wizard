<?php
namespace Sys25\ImageMapWizard\Form;

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Page\PageRenderer;

class ImageMapElement extends AbstractFormElement
{
    /**
     * Default field controls for this element.
     *
     * @var array
     */
    protected $defaultFieldControl = [
        'popup_sys25imagemap' => [
            'renderType' => 'popup_sys25imagemap',
        ],
    ];

    public function render()
    {

        $folder = 'templates/js/';
        GeneralUtility::makeInstance(PageRenderer::class)
            ->addRequireJsConfiguration([
                'paths' => [
                    'wizard-lib' => \TYPO3\CMS\Core\Utility\PathUtility::getAbsoluteWebPath(
                        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('imagemap_wizard', $folder)
                        ) . 'wizard.all.js.ycomp' // .js
                ],
                'shim' => [
                    'wizard-lib' => ['jquery'],
                ],
            ]);


        $resultArray = $this->initializeResultArray();
        $resultArray['requireJsModules'][] = 'wizard-lib';
        $parameterArray = $this->data['parameterArray'];
        $parameterArray['table'] = $this->data['tableName'];
        $parameterArray['field'] = $this->data['fieldName'];
        $parameterArray['row'] = $this->data['databaseRow'];
        $parameterArray['parameters'] = isset($parameterArray['fieldConf']['config']['parameters'])
            ? $parameterArray['fieldConf']['config']['parameters']
            : [];

        $elementHtml = '';
        $cntr = new \tx_imagemapwizard_controller_wizard();
        $elementHtml = $cntr->renderForm($parameterArray, $this);

        $fieldWizardResult = $this->renderFieldWizard();
        $fieldWizardHtml = $fieldWizardResult['html'];

        $fieldControlResult = $this->renderFieldControl();
        $fieldControlHtml = $fieldControlResult['html'];
        $resultArray = $this->mergeChildReturnIntoExistingResult($resultArray, $fieldControlResult, false);

        $html = [];
        $html[] =   '<div class="form-control-wrap">';
        $html[] =       '<div class="form-wizards-wrap">';
        $html[] =         '<div class="form-wizards-element">';
        $html[] =         $elementHtml;
        $html[] =         '</div>';
        $html[] =       '</div>';
        $html[] =       '<div class="form-wizards-items-aside">';
        $html[] =           '<div class="btn-group-vertical">';
        $html[] =               $fieldControlHtml;
        $html[] =           '</div>';
        $html[] =       '</div>';
        $html[] =       '<div class="form-wizards-items-aside">';
        $html[] =           $fieldWizardHtml;
        $html[] =       '</div>';
        $html[] =   '</div>';
        $html = implode(LF, $html);


        $resultArray['html'] = '<div class="formengine-field-item t3js-formengine-field-item">' . $html . '</div>';
        return $resultArray;
    }
}