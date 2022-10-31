<?php
/**
 * @author Pham Hong Thanh
 * @email thanhpham0990@gmail.com
 * @skype thanhpham170990
 */

class Cmsmart_Pricematrix_Model_Resource_Catalog_Product_Option_Type_Price_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract{

    public function _construct(){
        $this->_init('cmsmart_pricematrix/catalog_product_option_type_price');
    }
}