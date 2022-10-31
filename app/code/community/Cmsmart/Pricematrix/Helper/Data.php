<?php
/**
 * @author Pham Hong Thanh
 * @email thanhpham0990@gmail.com
 * @skype thanhpham170990
 */

class Cmsmart_Pricematrix_Helper_Data extends Mage_Core_Helper_Abstract{

    /**
     * Check enabled/disabled module
     */
    public function isEnabled(){
        return Mage::getStoreConfigFlag('pricematrix/general/enabled');
    }

    /**
     * Get color of background
     */
    public function getBackgroundColor(){
        $color = Mage::getStoreConfig('pricematrix/general/background_color');
        return '#'.$color;
    }

    /**
     * Get color of text
     */
    public function getTextColor(){
        $color = Mage::getStoreConfig('pricematrix/general/text_color');
        return '#'.$color;
    }

    /**
     * Get delimiter character
     */
    public function getDelimiter(){
        $delimiter = Mage::getStoreConfig('pricematrix/general/delimiter');
        return ' '.$delimiter.' ';
    }

    /**
     * Check row span
     */
    public function isRowspan(){
        return Mage::getStoreConfigFlag('pricematrix/general/rowspan');
    }

    /**
     * Check column span
     */
    public function isColspan(){
        return Mage::getStoreConfigFlag('pricematrix/general/colspan');
    }

    /**
     * Get the title of quantity
     */
    public function getQuantityTitle(){
        return Mage::getStoreConfig('pricematrix/general/quantity');
    }
}