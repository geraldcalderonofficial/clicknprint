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
 * @package     Mage_Sales
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Order item render block for grouped product type
 *
 * @category    Mage
 * @package     Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Cmsmart_OrderUpload_Block_Sales_Order_Item_Renderer_Grouped extends Mage_Sales_Block_Order_Item_Renderer_Grouped
{
/**
     * Return product additional information block
     *
     * @return Mage_Core_Block_Abstract
     */
    public function getProductAdditionalInformationBlock()
    {
    	//$productid=$this->getProduct()->getId();
    	$orderId=Mage::app()->getRequest()->getParam('order_id');
    	$order = Mage::getModel('sales/order')->load($orderId);
    	$orderItems = $order->getAllVisibleItems();
    	
    	$orderidFull=$order->getIncrementId();
    	
    	$proid=$this->getItem()->getProduct()->getId();
    	
    	//Zend_Debug::dump($proid);
    	
    	
    	// read content file order_id.json
    	$io = new Varien_Io_File();
    		
    	$path=Mage::getBaseDir('media').DS.'tmp'.DS.'orderupload'.DS.$proid.DS.$orderidFull.'.json';
    	$content=$io->read($path);
    	$arr_img=json_decode($content);
    	
    	//Zend_Debug::dump($arr_img);exit();
    	
    	//$div_img='';
    	if(!empty($arr_img))
    	{
    		$div_img='<br/>';
			$div_img.=$this->__('File Attached');
    		$div_img.='<br/>';
    		$div_img.='<table  class="data-table">';
    			$div_img.='<thead>';
	    			$div_img.='<tr>';
	    				$div_img.='<th align="center" width="100">'.Mage::helper('orderupload')->__('Files').'</th>';
	    				$div_img.='<th align="center">'.Mage::helper('orderupload')->__('Comments').'</th>';
	    			$div_img.='</tr>';
    			$div_img.='</thead>';
    			$div_img.='<tbody>';
    		foreach($arr_img as $img)
    		{
    			//$arr_=explode('/',$img);
    			$path_file=Mage::helper('orderupload')->switchImagesExt($proid,$img->label);
    			
 				$div_img.='<tr>';
 					$div_img.='<td>';
    					$div_img.='<a target="_blank" href="'.$img->image.'"><img style="margin:5px;border:1px solid #ccc;" width="50" height="50" src="'.$path_file.'" /></a>';
    				$div_img.='</td>';
    				$div_img.='<td>';
    					$div_img.='<textarea readonly="readonly" name="'.$img->label.'" cols="35" rows="5">'.$img->comment.'</textarea>';
    				$div_img.='</td>';
    			$div_img.='</tr>';	
    		}
    			$div_img.='</tbody>';
    		$div_img.='</table>';
    		
    		echo $div_img;
    	}
    			
    	//Zend_Debug::dump($arr_img);
    	
    	//Zend_Debug::dump($orderidFull);
    	
    	//echo 'It is me !.';
        return $this->getLayout()->getBlock('additional.product.info');
    }
}
