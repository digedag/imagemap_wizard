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
/**
 * Class/Function which renders the TCE-Form with the Data provided by the given Data-Object.
 *
 * @author	Tolleiv Nietsch <info@tolleiv.de>
 */

class tx_imagemapwizard_view_tceform extends tx_imagemapwizard_view_abstract {

	protected $form, $formName, $wizardConf;

	public function setTCEForm($form) {
		$this->form = $form;
	}

	/**
	 * Anzeige der Vorschau im TCE-Form. Die markierten Bereiche sind sichtbar.
	 *
	 * @return string	 the rendered form content
	 */
	public function renderContent() {
		if (!$this->data->hasValidImageFile()) {
			$content = $this->form->sL('LLL:EXT:imagemap_wizard/locallang.xml:form.no_image');
		} else {
		    $content = $this->renderTemplate('tceform.php');
		    $this->form->additionalCode_pre[] = $this->getExternalJSIncludes();
			$this->form->additionalCode_pre[] = $this->getInlineJSIncludes();
		}
		return $content;
	}

	public function setWizardConf($wConf) {
		$this->wizardConf = $wConf;
	}

	public function setFormName($name) {
		$this->formName = $name;
	}

	protected function renderTemplate($file) {

	    $this->addExternalJS("templates/js/jquery-1.4.min.js");
	    $this->addExternalJS("templates/js/jquery-ui-1.7.2.custom.min.js");
	    $this->addExternalJS("templates/js/jquery.base64.js");
	    $this->addExternalJS("templates/js/wizard.all.js.ycomp.js");

	    $existingFields = $this->data->listAreas("\tcanvasObject.addArea(new area##shape##Class(),'##coords##','##alt##','##link##','##color##',0);\n");
	    $this->addInlineJS('
jQuery.noConflict();
function imagemapwizard_valueChanged(field) {
    jQuery.ajaxSetup({
        url: "'.$this->getAjaxURL('wizard.php').'",
        global: false,
        type: "POST",
        success: function(data, textStatus) {
            if(textStatus==\'success\') {
                jQuery("#'.$this->getId().'").html(data);
            }
        },
        data: { context:"tceform",
                ajax: "1",
                formField:field.name,
                value:field.value,
                table:"'.$this->data->getTablename().'",
                field:"'.$this->data->getFieldname().'",
                uid:"'.$this->data->getUid().'",
                config:"'.addslashes(serialize($this->data->getFieldConf())).'"
        }
    });
    jQuery.ajax();
}
');
	    $additionalWizardConf = ['fieldChangeFunc'=>['imagemapwizard_valueChanged(field);']];

	    $out = '<div id="'.$this->getId().'" style="position:relative">';
	    $imagePreview = '    <div class="imagemap_wiz" style="padding:5px;overflow:hidden;position:relative">
        <div id="'.$this->getId().'-canvas" style="position:relative;top:5px;left:5px;overflow:hidden;">'.
        $this->data->renderThumbnail('previewImageMaxWH',200) .'
        </div>
    </div>
';

        $out .= $imagePreview;


        if($this->data->hasDirtyState()) {
            $out .= '<div class="imagemap_wiz_message" style="display:none;width:170px;height:70px;padding:20px 40px 10px 40px;position:absolute;z-index:999;background: url('.$this->getTplSubpath().'img/form-tooltip.png) no-repeat;">';
            $this->getLL('form.is_dirty',1);
            $out .= '<div class="imagemap_wiz_message_close" style="display:block;position:absolute;right:15px;top:15px;cursor:pointer">[x]</div></div>';
        }


        $out .= '
    <script type="text/javascript">
    $(document).ready(function(){
        canvasObject = new previewCanvasClass();
        canvasObject.init("'. $this->getId().'-canvas","'. $this->data->getThumbnailScale('previewImageMaxWH',200) .'");
        '. $existingFields .'
        jQuery(".imagemap_wiz_message").css({top: (canvasObject.getMaxH()/2-35)+"px", left: "20px"}).animate({left: "60px",opacity: "show"}, 750).animate({left: "60px"}, 6000).animate({left: "20px", opacity: "hide"}, 750);
        jQuery(".imagemap_wiz_message_close").click(function() {
            jQuery(".imagemap_wiz_message").animate({left: "20px", opacity: "hide"}, {duration:250, queue:false});
        });
    });
    </script>
    <input type="hidden" name="'. $this->formName.'" value="'. htmlspecialchars($this->data->getCurrentData()).'" />
';

        $out .= '</div>';

        return $out;
	}
}
