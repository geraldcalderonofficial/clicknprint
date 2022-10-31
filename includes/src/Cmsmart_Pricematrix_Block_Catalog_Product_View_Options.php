<?php
/**
 * @author Pham Hong Thanh
 * @email thanhpham0990@gmail.com
 * @skype thanhpham170990
 */
class Cmsmart_Pricematrix_Block_Catalog_Product_View_Options extends Mage_Catalog_Block_Product_View_Options{

    /**
     * Get option html block
     *
     * @param Mage_Catalog_Model_Product_Option $option
     */
    public function getOptionHtml(Mage_Catalog_Model_Product_Option $option){

        if(Mage::helper('cmsmart_pricematrix')->isEnabled()){

            if($option->getType() === 'matrix'){
                return;
            }

            $renderer = $this->getOptionRender(
                $this->getGroupOfOption($option->getType())
            );

            if (is_null($renderer['renderer'])) {
                $renderer['renderer'] = $this->getLayout()->createBlock($renderer['block'])
                    ->setTemplate($renderer['template']);
            }

            return $renderer['renderer']
                ->setProduct($this->getProduct())
                ->setOption($option)
                ->toHtml();
        }else{
            return parent::getOptionHtml($option);
        }
    }

    /**
     * Get json representation of
     *
     * @return string
     */
    public function getJsonConfig(){
        if(Mage::helper('cmsmart_pricematrix')->isEnabled()){
            $config = array();
            foreach ($this->getOptions() as $option) {
                /* @var $option Mage_Catalog_Model_Product_Option */
                $priceValue = 0;
                if ($option->getGroupByType() == Mage_Catalog_Model_Product_Option::OPTION_GROUP_SELECT) {
                    $_tmpPriceValues = array();
                    foreach ($option->getValues() as $value) {
                        /* @var $value Mage_Catalog_Model_Product_Option_Value */
                        $id = $value->getId();
                        $_tmpPriceValues[$id] = $this->_getPriceConfiguration($value);
                    }
                    $priceValue = $_tmpPriceValues;
                } elseif ($option->getGroupByType() == Cmsmart_Pricematrix_Model_Catalog_Product_Option::OPTION_GROUP_CMSMART) {
                    $_tmpPriceValues = array();
                    foreach ($option->getValues() as $value) {
                        /* @var $value Mage_Catalog_Model_Product_Option_Value */
                        $id = $value->getId();
                        $_tmpPriceValues[$id] = $this->_getPriceConfiguration($value);
                    }
                    $priceValue = $_tmpPriceValues;
                } else {
                    $priceValue = $this->_getPriceConfiguration($option);
                }
                $config[$option->getId()] = $priceValue;
            }
            return Mage::helper('core')->jsonEncode($config);
        }else{
            return parent::getJsonConfig();
        }
    }
}