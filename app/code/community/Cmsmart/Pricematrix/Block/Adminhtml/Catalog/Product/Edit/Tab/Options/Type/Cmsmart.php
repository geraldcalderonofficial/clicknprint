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
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Custom option type
 *
 * @author Pham Hong Thanh
 * @email thanhpham0990@gmail.com
 * @skype thanhpham170990
 */

//thanh
class Cmsmart_Pricematrix_Block_Adminhtml_Catalog_Product_Edit_Tab_Options_Type_Cmsmart extends
    Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Options_Type_Abstract
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
        if(Mage::helper('cmsmart_pricematrix')->isEnabled()){
            $this->setTemplate('cmsmart/pricematrix/catalog/product/edit/options/type/cmsmart.phtml');
        }
    }

    protected function _prepareLayout()
    {
        if(Mage::helper('cmsmart_pricematrix')->isEnabled()){
            $this->setChild('add_cmsmart_row_button',
                $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setData(array(
                        'label' => Mage::helper('catalog')->__('Add New Row'),
                        'class' => 'add add-cmsmart-row',
                        'id'    => 'add_cmsmart_row_button_{{option_id}}'
                    ))
            );

            $this->setChild('delete_cmsmart_row_button',
                $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setData(array(
                        'label' => Mage::helper('catalog')->__('Delete Row'),
                        'class' => 'delete delete-cmsmart-row icon-btn',
                        'id'    => 'delete_cmsmart_row_button'
                    ))
            );
        }
        return parent::_prepareLayout();
    }

    public function getAddButtonHtml()
    {
        if(Mage::helper('cmsmart_pricematrix')->isEnabled()){
            return $this->getChildHtml('add_cmsmart_row_button');
        }
    }

    public function getDeleteButtonHtml()
    {
        if(Mage::helper('cmsmart_pricematrix')->isEnabled()){
            return $this->getChildHtml('delete_cmsmart_row_button');
        }
    }

    public function getPriceTypeSelectHtml()
    {
        if(Mage::helper('cmsmart_pricematrix')->isEnabled()){
            $this->getChild('option_price_type')
                ->setData('id', 'product_option_{{id}}_cmsmart_{{cmsmart_id}}_price_type')
                ->setName('product[options][{{id}}][values][{{cmsmart_id}}][price_type]');
        }

        return parent::getPriceTypeSelectHtml();
    }
}
