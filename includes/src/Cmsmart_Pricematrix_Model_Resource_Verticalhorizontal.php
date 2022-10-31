<?php
/**
 * @author Pham Hong Thanh
 * @email thanhpham0990@gmail.com
 * @skype thanhpham170990
 */

class Cmsmart_Pricematrix_Model_Resource_Verticalhorizontal extends Mage_Core_Model_Resource_Db_Abstract{

    public function _construct(){
        $this->_init('cmsmart_pricematrix/vertical_horizontal', 'vertical_horizontal_id');
    }

    public function truncate() {
        $this->_getWriteAdapter()->query('TRUNCATE TABLE '.$this->getMainTable());
        return $this;
    }

}