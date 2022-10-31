<?php
/**
 * @author Pham Hong Thanh
 * @email thanhpham0990@gmail.com
 * @skype thanhpham170990
 */

class Cmsmart_Pricematrix_Model_Resource_Catalog_Product_Option extends Mage_Catalog_Model_Resource_Product_Option{

    /**
     * Get option title
     */
    public function getOptionTitle(Mage_Catalog_Model_Product_Option $option){

        $read   = $this->_getReadAdapter();

        // read and prepare original product options
        $select = $read->select()
            ->from($this->getTable('catalog/product_option_title'))
            ->where('option_id = ?', $option->getId());

        $query = $read->query($select);

        $row = $query->fetch();

        return $row['title'];

    }

}