<?php
/**
 * @author Pham Hong Thanh
 * @email thanhpham0990@gmail.com
 * @skype thanhpham170990
 */

require_once(Mage::getModuleDir('controllers','Mage_Adminhtml').DS.'Catalog'.DS.'ProductController.php');
class Cmsmart_Pricematrix_Adminhtml_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController{

    /**
     * Get price matrix
     */
    public function pricematrixAction(){
        $this->_initProduct();
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->getBlock('catalog.product.edit.tab.pricematrix')
        );
        $this->renderLayout();
    }

    /**
     * Save product action
     */
    public function saveAction(){
        if(Mage::helper('cmsmart_pricematrix')->isEnabled()){
            $storeId        = $this->getRequest()->getParam('store');
            $redirectBack   = $this->getRequest()->getParam('back', false);
            $productId      = $this->getRequest()->getParam('id');
            $isEdit         = (int)($this->getRequest()->getParam('id') != null);

            $data = $this->getRequest()->getPost();

            if ($data) {
                $this->_filterStockData($data['product']['stock_data']);

                $product = $this->_initProductSave();



                try {
                    $product->save();
                    $productId = $product->getId();
                    // thanh
                    Mage::dispatchEvent(
                        'pricematrix_catalog_product_save_after',
                        array('product' => $product, 'request' => $this->getRequest())
                    );

                    if (isset($data['copy_to_stores'])) {
                        $this->_copyAttributesBetweenStores($data['copy_to_stores'], $product);
                    }

                    $this->_getSession()->addSuccess($this->__('The product has been saved.'));
                } catch (Mage_Core_Exception $e) {
                    $this->_getSession()->addError($e->getMessage())
                        ->setProductData($data);
                    $redirectBack = true;
                } catch (Exception $e) {
                    Mage::logException($e);
                    $this->_getSession()->addError($e->getMessage());
                    $redirectBack = true;
                }
            }

            if ($redirectBack) {
                $this->_redirect('*/*/edit', array(
                    'id'    => $productId,
                    '_current'=>true
                ));
            } elseif($this->getRequest()->getParam('popup')) {
                $this->_redirect('*/*/created', array(
                    '_current'   => true,
                    'id'         => $productId,
                    'edit'       => $isEdit
                ));
            } else {
                $this->_redirect('*/*/', array('store'=>$storeId));
            }
        }else{
            return parent::saveAction();
        }
    }
}