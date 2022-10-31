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
 * @package     Mage_Checkout
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Shopping cart item render block
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Cmsmart_OrderUpload_Block_Checkout_Cart_Item_Renderer_Configurable extends Mage_Checkout_Block_Cart_Item_Renderer_Configurable
{
	/**
	 * Return product additional information block
	 *
	 * @return Mage_Core_Block_Abstract
	 */
	public function getProductAdditionalInformationBlock()
	{
	
		//$product_ids = Mage::getModel('checkout/cart')->getProductIds();
		$productid=$this->getProduct()->getId();
		//Zend_Debug::dump($productid);
		///echo 'yes all';
		
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
					$i=0;
					foreach($items as $item)
					{
						$data_item=$item->getData();
						//Zend_Debug::dump($data['set_product_id']);exit();
						if($productid == intval($data_item['set_product_id']))
						{
							if($i == 0){
								// break line
								$value.=$this->__('File Attached').'<br/>';
							}
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
						$i++;
					}
					
					if($check_image)
					{
						$value.='</tbody>';
						$value.='</table>';
					}
					echo $value;
				}
			}
	
	
		return $this->getLayout()->getBlock('additional.product.info');
	}
}
