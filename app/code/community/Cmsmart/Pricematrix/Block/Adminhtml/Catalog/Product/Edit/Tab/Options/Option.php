<?php
/**
 * @author Pham Hong Thanh
 * @email thanhpham0990@gmail.com
 * @skype thanhpham170990
 */
class Cmsmart_Pricematrix_Block_Adminhtml_Catalog_Product_Edit_Tab_Options_Option extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Options_Option{

    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
        if(Mage::helper('cmsmart_pricematrix')->isEnabled()){
            $this->setTemplate('cmsmart/pricematrix/catalog/product/edit/options/option.phtml');
            $this->setCanReadPrice(true);
            $this->setCanEditPrice(true);
        }
    }

    /**
     * Retrieve html templates for different types of product custom options
     *
     * @return string
     */
    public function getTemplatesHtml()
    {
        if(Mage::helper('cmsmart_pricematrix')->isEnabled()){

            $canEditPrice = $this->getCanEditPrice();
            $canReadPrice = $this->getCanReadPrice();

            $this->getChild('select_option_type')
                ->setCanReadPrice($canReadPrice)
                ->setCanEditPrice($canEditPrice);

            // thanh
            $this->getChild('cmsmart_option_type')
                ->setCanReadPrice($canReadPrice)
                ->setCanEditPrice($canEditPrice);

            $this->getChild('file_option_type')
                ->setCanReadPrice($canReadPrice)
                ->setCanEditPrice($canEditPrice);

            $this->getChild('date_option_type')
                ->setCanReadPrice($canReadPrice)
                ->setCanEditPrice($canEditPrice);

            $this->getChild('text_option_type')
                ->setCanReadPrice($canReadPrice)
                ->setCanEditPrice($canEditPrice);

            // thanh
            $templates = $this->getChildHtml('text_option_type') . "\n" .
                $this->getChildHtml('file_option_type') . "\n" .
                $this->getChildHtml('select_option_type') . "\n" .
                $this->getChildHtml('cmsmart_option_type') . "\n" .
                $this->getChildHtml('date_option_type');

            return $templates;

        }else{
            return parent::getTemplatesHtml();
        }
    }

    public function getOptionValues(){

        if(Mage::helper('cmsmart_pricematrix')->isEnabled()){

            $optionsArr = array_reverse($this->getProduct()->getOptions(), true);

            if (!$this->_values) {
                $showPrice = $this->getCanReadPrice();
                $values = array();
                $scope = (int) Mage::app()->getStore()->getConfig(Mage_Core_Model_Store::XML_PATH_PRICE_SCOPE);
                foreach ($optionsArr as $option) {
                    /* @var $option Mage_Catalog_Model_Product_Option */

                    $this->setItemCount($option->getOptionId());

                    $value = array();

                    $value['id'] = $option->getOptionId();
                    $value['item_count'] = $this->getItemCount();
                    $value['option_id'] = $option->getOptionId();
                    $value['title'] = $this->escapeHtml($option->getTitle());
                    $value['type'] = $option->getType();
                    $value['is_require'] = $option->getIsRequire();
                    $value['sort_order'] = $option->getSortOrder();
                    $value['can_edit_price'] = $this->getCanEditPrice();

                    if ($this->getProduct()->getStoreId() != '0') {
                        $value['checkboxScopeTitle'] = $this->getCheckboxScopeHtml($option->getOptionId(), 'title',
                            is_null($option->getStoreTitle()));
                        $value['scopeTitleDisabled'] = is_null($option->getStoreTitle())?'disabled':null;
                    }

                    if ($option->getGroupByType() == Mage_Catalog_Model_Product_Option::OPTION_GROUP_SELECT) {

//                    $valuesArr = array_reverse($option->getValues(), true);

                        $i = 0;
                        $itemCount = 0;
                        foreach ($option->getValues() as $_value) {
                            /* @var $_value Mage_Catalog_Model_Product_Option_Value */
                            $value['optionValues'][$i] = array(
                                'item_count' => max($itemCount, $_value->getOptionTypeId()),
                                'option_id' => $_value->getOptionId(),
                                'option_type_id' => $_value->getOptionTypeId(),
                                'title' => $this->escapeHtml($_value->getTitle()),
                                'price' => ($showPrice)
                                        ? $this->getPriceValue($_value->getPrice(), $_value->getPriceType()) : '',
                                'price_type' => ($showPrice) ? $_value->getPriceType() : 0,
                                'sku' => $this->escapeHtml($_value->getSku()),
                                'sort_order' => $_value->getSortOrder(),
                            );

                            if ($this->getProduct()->getStoreId() != '0') {
                                $value['optionValues'][$i]['checkboxScopeTitle'] = $this->getCheckboxScopeHtml(
                                    $_value->getOptionId(), 'title', is_null($_value->getStoreTitle()),
                                    $_value->getOptionTypeId());
                                $value['optionValues'][$i]['scopeTitleDisabled'] = is_null($_value->getStoreTitle())
                                    ? 'disabled' : null;
                                if ($scope == Mage_Core_Model_Store::PRICE_SCOPE_WEBSITE) {
                                    $value['optionValues'][$i]['checkboxScopePrice'] = $this->getCheckboxScopeHtml(
                                        $_value->getOptionId(), 'price', is_null($_value->getstorePrice()),
                                        $_value->getOptionTypeId());
                                    $value['optionValues'][$i]['scopePriceDisabled'] = is_null($_value->getStorePrice())
                                        ? 'disabled' : null;
                                }
                            }
                            $i++;
                        }
                        // thanh
                    }elseif($option->getGroupByType() == Cmsmart_Pricematrix_Model_Catalog_Product_Option::OPTION_GROUP_CMSMART){

                        $i = 0;
                        $itemCount = 0;
                        foreach ($option->getValues() as $_value) {
                            /* @var $_value Mage_Catalog_Model_Product_Option_Value */
                            $value['optionValues'][$i] = array(
                                'item_count' => max($itemCount, $_value->getOptionTypeId()),
                                'option_id' => $_value->getOptionId(),
                                'option_type_id' => $_value->getOptionTypeId(),
                                'title' => $this->escapeHtml($_value->getTitle()),
                                'price' => ($showPrice)
                                        ? $this->getPriceValue($_value->getPrice(), $_value->getPriceType()) : '',
                                'price_type' => ($showPrice) ? $_value->getPriceType() : 0,
                                'sku' => $this->escapeHtml($_value->getSku()),
                                'sort_order' => $_value->getSortOrder(),
                            );

                            if ($this->getProduct()->getStoreId() != '0') {
                                $value['optionValues'][$i]['checkboxScopeTitle'] = $this->getCheckboxScopeHtml(
                                    $_value->getOptionId(), 'title', is_null($_value->getStoreTitle()),
                                    $_value->getOptionTypeId());
                                $value['optionValues'][$i]['scopeTitleDisabled'] = is_null($_value->getStoreTitle())
                                    ? 'disabled' : null;
                                if ($scope == Mage_Core_Model_Store::PRICE_SCOPE_WEBSITE) {
                                    $value['optionValues'][$i]['checkboxScopePrice'] = $this->getCheckboxScopeHtml(
                                        $_value->getOptionId(), 'price', is_null($_value->getstorePrice()),
                                        $_value->getOptionTypeId());
                                    $value['optionValues'][$i]['scopePriceDisabled'] = is_null($_value->getStorePrice())
                                        ? 'disabled' : null;
                                }
                            }
                            $i++;
                        }

                    } else {
                        $value['price'] = ($showPrice)
                            ? $this->getPriceValue($option->getPrice(), $option->getPriceType()) : '';
                        $value['price_type'] = $option->getPriceType();
                        $value['sku'] = $this->escapeHtml($option->getSku());
                        $value['max_characters'] = $option->getMaxCharacters();
                        $value['file_extension'] = $option->getFileExtension();
                        $value['image_size_x'] = $option->getImageSizeX();
                        $value['image_size_y'] = $option->getImageSizeY();
                        if ($this->getProduct()->getStoreId() != '0' &&
                            $scope == Mage_Core_Model_Store::PRICE_SCOPE_WEBSITE) {
                            $value['checkboxScopePrice'] = $this->getCheckboxScopeHtml($option->getOptionId(),
                                'price', is_null($option->getStorePrice()));
                            $value['scopePriceDisabled'] = is_null($option->getStorePrice())?'disabled':null;
                        }
                    }
                    $values[] = new Varien_Object($value);
                }
                $this->_values = $values;
            }

            return $this->_values;

        }else{
            return parent::getOptionValues();
        }
    }

//    protected function _prepareLayout(){
//        $this->setChild('delete_button',
//            $this->getLayout()->createBlock('adminhtml/widget_button')
//                ->setData(array(
//                    'label' => Mage::helper('catalog')->__('Delete Option'),
//                    'class' => 'delete delete-product-option '
//                ))
//        );
//
//        $path = 'global/catalog/product/options/custom/groups';
//
//        foreach (Mage::getConfig()->getNode($path)->children() as $group) {
//            if($group->getName() !== 'cmsmart'){
//                $this->setChild($group->getName() . '_option_type',
//                    $this->getLayout()->createBlock(
//                        (string) Mage::getConfig()->getNode($path . '/' . $group->getName() . '/render')
//                    )
//                );
//            }
//        }
//
//        return parent::_prepareLayout();
//    }

}