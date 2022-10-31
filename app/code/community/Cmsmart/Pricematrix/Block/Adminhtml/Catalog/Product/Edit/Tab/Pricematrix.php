<?php
/**
 * @author Pham Hong Thanh
 * @email thanhpham0990@gmail.com
 * @skype thanhpham170990
 */
class Cmsmart_Pricematrix_Block_Adminhtml_Catalog_Product_Edit_Tab_Pricematrix extends Mage_Adminhtml_Block_Widget_Form{

    public function __construct(){
        parent::__construct();
        if(Mage::helper('cmsmart_pricematrix')->isEnabled()){
            $this->setTemplate('cmsmart/pricematrix/catalog/product/edit/tab/pricematrix.phtml');
        }
    }

}