<?php

class Mage_Core_Helper_Nborderupload extends Mage_Core_Helper_Abstract {

    public function integrateOrderUpload() {
        $result = '';
        if (Mage::helper('core/data')->isModuleEnabled('Cmsmart_OrderUpload')){
            $result = Mage::helper('orderupload/data')->integrateOrderUpload();
        }
        
        return $result;
    }
}