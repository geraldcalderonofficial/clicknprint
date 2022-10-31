<?php
/**
 * @author Pham Hong Thanh
 * @email thanhpham0990@gmail.com
 * @skype thanhpham170990
 */

class Cmsmart_Pricematrix_Model_Verticalhorizontal extends Mage_Core_Model_Abstract{

    public function __construct(){
        $this->_init('cmsmart_pricematrix/verticalhorizontal');
    }

    public function truncate() {
        $this->getResource()->truncate();
        return $this;
    }
}