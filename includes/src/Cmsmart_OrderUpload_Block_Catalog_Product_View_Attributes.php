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
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Product description block
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Cmsmart_OrderUpload_Block_Catalog_Product_View_Attributes extends Mage_Catalog_Block_Product_View_Attributes
{

    /**
     * $excludeAttr is optional array of attribute codes to
     * exclude them from additional data array
     *
     * @param array $excludeAttr
     * @return array
     */
    public function getAdditionalData(array $excludeAttr = array())
    {
        $data = array();
        $product = $this->getProduct();
        $attributes = $product->getAttributes();
        $storeId = Mage::app()->getStore()->getStoreId();
		$product_id = Mage::registry('current_product')->getId();
		$attribute = Mage::getResourceModel('catalog/product')->getAttributeRawValue($product_id, 'order_upload', $storeId);
		if($attribute == 1){
		//print_r($attributes);die;
        foreach ($attributes as $attribute) {
//            if ($attribute->getIsVisibleOnFront() && $attribute->getIsUserDefined() && !in_array($attribute->getAttributeCode(), $excludeAttr)) {
            if ($attribute->getIsVisibleOnFront() && !in_array($attribute->getAttributeCode(), $excludeAttr)) {
				// get attr_code
				$attr_code = $attribute->getAttributeCode();
                
				$value = $attribute->getFrontend()->getValue($product);
				
				// get attribute code of order upload extension
				$param_code = Mage::getStoreConfig('orderupload/general/attr_code');				
				
				if($attr_code == $param_code){
					
					$value='<div class="box_upload">';
						$value.='<p>'.Mage::helper('orderupload')->__('Text Info').'</p>';
						$value.='<a class="show_upload"  onclick="';
						$value.="return showFormUpload('upload_files_nbm')";
						$value.='"';
						$value.=' href="#">'.Mage::helper('orderupload')->__('Click Here').'</a>';
						$value.='<br/>';
					$value.='</div>';
					//Mage::helper('orderupload')->switchImages();
					
					$value.='<div id="list_allimages">';
					// List image attach if it upload done
					$productid=$product->getId();
					$obj_getcolect=Mage::getSingleton('core/session')->getObjProducts();
					if(is_object($obj_getcolect))
					{
						// break line
						//$value.='<br/>';
						$items=$obj_getcolect->getItems();
						if(!empty($items))
						{
							// link update and remove
							$url_update=Mage::getUrl('orderupload/gallery/updateInfo', array('productid' => $productid));
							
							$url_delete=Mage::getUrl('orderupload/gallery/deleteImage', array('productid' => $productid));
							
							//check product have images or not , if have show table , if not hide table
							$check_image=Mage::helper('orderupload')->checkProduct($items,$productid);
							
							//Zend_Debug::dump($items);
							// Start create table
							if($check_image)
							{
								$value.='<table class="data-table">';
								$value.='<thead>';
								$value.='<tr>';
								$value.='<th>'.Mage::helper('orderupload')->__('Files').'</th>';
								$value.='<th>'.Mage::helper('orderupload')->__('Label').'</th>';
								$value.='<th>'.Mage::helper('orderupload')->__('Actions').'</th>';
								$value.='</tr>';
								$value.='</thead>';
								$value.='<tbody>';
							}
							foreach($items as $item)
							{
								$data_item=$item->getData();
								//Zend_Debug::dump($data['set_product_id']);exit();
								if($productid == intval($data_item['set_product_id']))
								{
									// get extension of file and set for images
									$path_file=Mage::helper('orderupload')->switchImages($productid,$data_item);
									$value.='<tr>';
									
									$value.='<td>';
										$value.='<a target="_blank" href="'.Mage::getBaseUrl('media').'tmp/orderupload'.$data_item['set_files']['file'].'"><img width="50" height="50" style="margin:5px;border:1px solid #ccc;" src="'.$path_file.'" /></a>';
									$value.='</td>';
									
									$value.='<td>';
										if($data_item['set_comment'] != '')
											$value.='<textarea cols="35" rows="5" id="'.$data_item['set_files']['label'].'" name="'.$data_item['set_files']['label'].'" >'.$data_item['set_comment'].'</textarea>';
										else
											$value.='<textarea cols="35" rows="5" id="'.$data_item['set_files']['label'].'" name="'.$data_item['set_files']['label'].'" placeholder="Extra information" ></textarea>';
									$value.='</td>';
									
									$value.='<td>';
										$value.='<button type="button" style="margin-bottom:5px;" class="button" title="'.Mage::helper('orderupload')->__('Edit').'" onclick="var edit_=new Product1.Gallery();edit_.updateInfoDetail(this,'."'".$url_update."'".','."'".$data_item['set_files']['label']."'".');" ><span><span>'.Mage::helper('orderupload')->__('Update').'</span></span></button>';
										$value.='<br/>';
										$value.='<button type="button" class="button" title="'.Mage::helper('orderupload')->__('Remove').'" onclick="var edit_=new Product1.Gallery();edit_.deleteImageDetail(this,'."'".$url_delete."'".','."'".$data_item['set_files']['label']."'".');" ><span><span>'.Mage::helper('orderupload')->__('Remove').'</span></span></button>';
									$value.='</td>';
									
									$value.='</tr>';
								}
							}
							
							// End of table
							if($check_image)
							{
								$value.='</tbody>';
								$value.='</table>';
							}
						}
					}
					
					$value.='</div>';
				}
				
				
                if (!$product->hasData($attribute->getAttributeCode())) {
                    $value = Mage::helper('catalog')->__('N/A');
                } elseif ((string)$value == '') {
                    $value = Mage::helper('catalog')->__('No');
                } elseif ($attribute->getFrontendInput() == 'price' && is_string($value)) {
                    $value = Mage::app()->getStore()->convertPrice($value, true);
                }

                if (is_string($value) && strlen($value)) {
                    $data[$attribute->getAttributeCode()] = array(
                        'label' => $attribute->getStoreLabel(),
                        'value' => $value,
                        'code'  => $attribute->getAttributeCode()
                    );
                }
            }
        }
        return $data;
    	}
    }
}
