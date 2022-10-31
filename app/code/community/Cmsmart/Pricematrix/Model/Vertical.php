<?php
/**
 * @author Pham Hong Thanh
 * @email thanhpham0990@gmail.com
 * @skype thanhpham170990
 */

class Cmsmart_Pricematrix_Model_Vertical extends Mage_Core_Model_Abstract{

    public function __construct(){
        $this->_init('cmsmart_pricematrix/vertical');
    }

    public function truncate() {
        $this->getResource()->truncate();
        return $this;
    }
}