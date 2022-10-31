<?php
/**
 * @author Pham Hong Thanh
 * @email thanhpham0990@gmail.com
 * @skype thanhpham170990
 */

class Cmsmart_Pricematrix_Model_Observer extends Mage_Core_Model_Abstract{

    public function pricematrixCatalogProductSaveAfter($observer){
        if(Mage::helper('cmsmart_pricematrix')->isEnabled()){
            /**
             * Get all current price matrix option
             */
            $product = $observer->getEvent()->getProduct();
            $productId = $product->getId();

            $currentOptions = array();
            $optionCollection = Mage::getModel('catalog/product_option')->getCollection()
                ->addFieldToFilter('type', array('eq'=>'matrix'))
                ->addFieldToFilter('product_id', array('eq'=>$productId));

            foreach($optionCollection as $option){
                $currentOptions[] = $option->getId();
            }

            /**
             * Check exist vertical option in $currentOption
             * If exist, delete all group option of vertical
             */
            $verticalCollection = Mage::getModel('cmsmart_pricematrix/vertical')
                ->getCollection()
                ->addFieldToFilter('product', array('eq'=>$productId))
                ->addFieldToFilter('value', array('nin'=>$currentOptions));

            if(count($verticalCollection) > 0){
                foreach($verticalCollection as $vertical){
                    $vertical->delete();
                }
                $verticalhorizontalCollection = Mage::getModel('cmsmart_pricematrix/verticalhorizontal')
                    ->getCollection()
                    ->addFieldToFilter('direct', array('eq'=>'vertical'));
                if(count($verticalhorizontalCollection) > 0){
                    foreach($verticalhorizontalCollection as $verticalhorizontal){
                        $verticalhorizontal->delete();
                    }
                }
            }

            /**
             * Check exist horizontal option in $currentOption
             * If exist, delete all group option of horizontal
             */
            $horizontalCollection = Mage::getModel('cmsmart_pricematrix/horizontal')
                ->getCollection()
                ->addFieldToFilter('product', array('eq'=>$productId))
                ->addFieldToFilter('value', array('nin'=>$currentOptions));

            if(count($horizontalCollection) > 0){
                foreach($horizontalCollection as $horizontal){
                    $horizontal->delete();
                }
                $verticalhorizontalCollection = Mage::getModel('cmsmart_pricematrix/verticalhorizontal')
                    ->getCollection()
                    ->addFieldToFilter('direct', array('eq'=>'horizontal'));
                if(count($verticalhorizontalCollection) > 0){
                    foreach($verticalhorizontalCollection as $verticalhorizontal){
                        $verticalhorizontal->delete();
                    }
                }
            }

            /**
             * Check exist horizontal or vertical option in $currentOption
             * If exist, delete price matrix table of product
             */

            if((count($verticalCollection) > 0) || (count($horizontalCollection) > 0)){
                $matrixCollection = Mage::getModel('cmsmart_pricematrix/matrix')
                    ->getCollection()
                    ->addFieldToFilter('product', array('eq'=>$productId));
                if(count($matrixCollection) > 0){
                    foreach($matrixCollection as $matrix){
                        $matrix->delete();
                    }
                }

                echo Mage::getSingleton('core/session')->addNotice('You have just deleted price matrix custom option. Please update price matrix !');
            }
        }
    }

}