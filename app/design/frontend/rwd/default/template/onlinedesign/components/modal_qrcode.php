<?php
$current_theme = Mage::getSingleton('core/design_package')->getPackageName();
$img_skin_path_css = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/'.$current_theme.'/default/cmsmart/onlinedesign/css/images';
?>
<div id="dg-qrcode"  class="modal fade nbdesigner_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5><?php echo $this->__("QR Code") ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>			
                <div class="modal-body">
                    <div>
                        <textarea class="form-control nbdesigner_textarea" id="qrcode-content" ng-model="qrCodeContent"></textarea>
                    </div>
                    <div class="text-center">
                        <button class="nbdesigner_button shadow hover-shadow" ng-click="getQrCode()"><?php echo $this->__("Create QRCode") ?></button>
                        <img id="loading_qrcode" style="margin-left: 15px;" class="hidden" src="<?php echo $img_skin_path_css .'/ajax-loader.gif'; ?>" />	
                    </div>
                    <div id="qrcode-img"></div>                    
                </div>
            </div>            
        </div>
    </div>
</div>