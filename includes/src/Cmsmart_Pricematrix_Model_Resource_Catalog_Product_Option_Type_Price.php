<?php
/**
 * @author Pham Hong Thanh
 * @email thanhpham0990@gmail.com
 * @skype thanhpham170990
 */

class Cmsmart_Pricematrix_Model_Resource_Catalog_Product_Option_Type_Price
    extends Mage_Core_Model_Resource_Db_Abstract{

    /**
     * Resource initialization
     */
    protected function _construct()
    {
        $this->_init('catalog/product_option_type_price', 'option_type_price_id');
    }
}