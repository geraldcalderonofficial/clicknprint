<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog product option model
 *
 * @method Mage_Catalog_Model_Resource_Product_Option _getResource()
 * @method Mage_Catalog_Model_Resource_Product_Option getResource()
 * @method int getProductId()
 * @method Mage_Catalog_Model_Product_Option setProductId(int $value)
 * @method string getType()
 * @method Mage_Catalog_Model_Product_Option setType(string $value)
 * @method int getIsRequire()
 * @method Mage_Catalog_Model_Product_Option setIsRequire(int $value)
 * @method string getSku()
 * @method Mage_Catalog_Model_Product_Option setSku(string $value)
 * @method int getMaxCharacters()
 * @method Mage_Catalog_Model_Product_Option setMaxCharacters(int $value)
 * @method string getFileExtension()
 * @method Mage_Catalog_Model_Product_Option setFileExtension(string $value)
 * @method int getImageSizeX()
 * @method Mage_Catalog_Model_Product_Option setImageSizeX(int $value)
 * @method int getImageSizeY()
 * @method Mage_Catalog_Model_Product_Option setImageSizeY(int $value)
 * @method int getSortOrder()
 * @method Mage_Catalog_Model_Product_Option setSortOrder(int $value)
 *
 */

/**
 * @author Pham Hong Thanh
 * @email thanhpham0990@gmail.com
 * @skype thanhpham170990
 */

class Cmsmart_Pricematrix_Model_Catalog_Product_Option extends Mage_Catalog_Model_Product_Option{

    /**
     * Option group cmsmart
     */
    // thanh
    const OPTION_GROUP_CMSMART = 'cmsmart';


    /**
     * Option type matrix
     */
    // thanh
    const OPTION_TYPE_MATRIX = 'matrix';


    /**
     * Get group name of option by given option type
     *
     * @param string $type
     * @return string
     */
    public function getGroupByType($type = null)
    {
        if(Mage::helper('cmsmart_pricematrix')->isEnabled()){
            if (is_null($type)) {
                $type = $this->getType();
            }
            $group = parent::getGroupByType($type);
            if(($group === '') && ($type == self::OPTION_TYPE_MATRIX)){
                $group = self::OPTION_GROUP_CMSMART;
            }
            return $group;
        }else{
            return parent::getGroupByType($type);
        }
    }

    /**
     * Group model factory
     *
     * @param string $type Option type
     * @return Mage_Catalog_Model_Product_Option_Group_Abstract
     */
    public function groupFactory($type){
        if(Mage::helper('cmsmart_pricematrix')->isEnabled()){
            if($type === self::OPTION_TYPE_MATRIX){
                return Mage::getModel('cmsmart_pricematrix/catalog_product_option_type_cmsmart');
            }
            return parent::groupFactory($type);
        }else{
            return parent::groupFactory($type);
        }
    }

    /**
     * Save options.
     *
     * @return Mage_Catalog_Model_Product_Option
     */
    public function saveOptions(){
        if(Mage::helper('cmsmart_pricematrix')->isEnabled()){
            foreach ($this->getOptions() as $option) {

                $this->setData($option)
                    ->setData('product_id', $this->getProduct()->getId())
                    ->setData('store_id', $this->getProduct()->getStoreId());

                if ($this->getData('option_id') == '0') {
                    $this->unsetData('option_id');
                } else {
                    $this->setId($this->getData('option_id'));
                }

                $isEdit = (bool)$this->getId() ? true:false;

                if ($this->getData('is_delete') == '1') {
                    if ($isEdit) {
                        $this->getValueInstance()->deleteValue($this->getId());
                        $this->deletePrices($this->getId());
                        $this->deleteTitles($this->getId());
                        $this->delete();
                    }
                } else {
                    if ($this->getData('previous_type') != '') {
                        $previousType = $this->getData('previous_type');

                        /**
                         * if previous option has different group from one is came now
                         * need to remove all data of previous group
                         */
                        if ($this->getGroupByType($previousType) != $this->getGroupByType($this->getData('type'))) {

                            switch ($this->getGroupByType($previousType)) {
                                case self::OPTION_GROUP_SELECT:
                                    $this->unsetData('values');
                                    if ($isEdit) {
                                        $this->getValueInstance()->deleteValue($this->getId());
                                    }
                                    break;
                                // thanh
                                case self::OPTION_GROUP_CMSMART:
                                    $this->unsetData('values');
                                    if ($isEdit) {
                                        $this->getValueInstance()->deleteValue($this->getId());
                                    }
                                    break;
                                case self::OPTION_GROUP_FILE:
                                    $this->setData('file_extension', '');
                                    $this->setData('image_size_x', '0');
                                    $this->setData('image_size_y', '0');
                                    break;
                                case self::OPTION_GROUP_TEXT:
                                    $this->setData('max_characters', '0');
                                    break;
                                case self::OPTION_GROUP_DATE:
                                    break;
                            }

                            if ($this->getGroupByType($this->getData('type')) == self::OPTION_GROUP_SELECT) {
                                $this->setData('sku', '');
                                $this->unsetData('price');
                                $this->unsetData('price_type');
                                if ($isEdit) {
                                    $this->deletePrices($this->getId());
                                }
                            }

                            if ($this->getGroupByType($this->getData('type')) == self::OPTION_GROUP_CMSMART) {
                                $this->setData('sku', '');
                                $this->unsetData('price');
                                $this->unsetData('price_type');
                                if ($isEdit) {
                                    $this->deletePrices($this->getId());
                                }
                            }
                        }
                    }
                    $this->save();
                }
            }//eof foreach()
            return $this;
        }else{
            return parent::saveOptions();
        }
    }

    /**
     * After save
     *
     * @return Mage_Core_Model_Abstract
     */
    protected function _afterSave(){
        if(Mage::helper('cmsmart_pricematrix')->isEnabled()){
            $this->getValueInstance()->unsetValues();
            if (is_array($this->getData('values'))) {
                foreach ($this->getData('values') as $value) {
                    $this->getValueInstance()->addValue($value);
                }

                $this->getValueInstance()->setOption($this)
                    ->saveValues();
            } elseif ($this->getGroupByType($this->getType()) == self::OPTION_GROUP_SELECT) {
                Mage::throwException(Mage::helper('catalog')->__('Select type options required values rows.'));
            }elseif ($this->getGroupByType($this->getType()) == self::OPTION_GROUP_CMSMART) {
                Mage::throwException(Mage::helper('catalog')->__('Select type options required values rows.'));
            }
            return Mage_Core_Model_Abstract::_afterSave();
        }else{
            return Mage_Core_Model_Abstract::_afterSave();
        }
    }

    /**
     * Get option title
     */
    public function getOptionTitle(Mage_Catalog_Model_Product_Option $option){
        return $this->getResource()->getOptionTitle($option);
    }

}

