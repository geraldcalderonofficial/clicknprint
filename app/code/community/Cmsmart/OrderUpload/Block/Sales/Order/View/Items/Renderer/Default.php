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
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Adminhtml sales order item renderer
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 */
class Cmsmart_OrderUpload_Block_Sales_Order_View_Items_Renderer_Default extends Mage_Adminhtml_Block_Sales_Order_View_Items_Renderer_Default
{
/**
     * Retrieve rendered column html content
     *
     * @param Varien_Object $item
     * @param string $column the column key
     * @param string $field the custom item field
     * @return string
     */
    public function getColumnHtml(Varien_Object $item, $column, $field = null)
    {
    	//echo 'It is me !.';
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
    	
    	$div_img='';
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
    	}
    	
    	
        if ($item->getOrderItem()) {
            $block = $this->getColumnRenderer($column, $item->getOrderItem()->getProductType());
        } else {
            $block = $this->getColumnRenderer($column, $item->getProductType());
        }

        if ($block) {
            $block->setItem($item);
            if (!is_null($field)) {
                $block->setField($field);
            }
            
            if($column == 'name')
            	return $block->toHtml().'<br/>'.$div_img;
           	 else
           	 	return $block->toHtml();
        }
        
        
        return '&nbsp;';
    }

}
