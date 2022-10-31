<?php
/**
* @copyright Amasty.
*/ 
class Cmsmart_OrderUpload_Helper_Data extends Mage_Core_Helper_Abstract
{
   public function switchImages($productid,$data_item)
   {
   		$dir_file=Mage::getBaseDir('media').DS.'tmp'.DS.'orderupload'.DS.$productid.DS.$data_item['set_files']['name'];
		$part=pathinfo($dir_file);
		
		switch ($part['extension'])
		{
			case 'doc':
			case 'docx':
				$path_file=Mage::getBaseUrl('media').'tmp/orderupload/icons/doc.png';
				break;
			case 'xls':
			case 'xlsx':
				$path_file=Mage::getBaseUrl('media').'tmp/orderupload/icons/xls.png';
				break;
			case 'zip':
			case 'rar':
				$path_file=Mage::getBaseUrl('media').'tmp/orderupload/icons/zip.png';
				break;
			case 'txt':
				$path_file=Mage::getBaseUrl('media').'tmp/orderupload/icons/txt.png';
				break;
			case 'pdf':
				$path_file=Mage::getBaseUrl('media').'tmp/orderupload/icons/pdf.png';
				break;
			case 'jpg':
			case 'png':
			case 'jpeg':
			case 'gif':
			case 'ico':
			case 'btm':
				$path_file=Mage::getBaseUrl('media').'tmp/orderupload'.$data_item['set_files']['file'];
				break;
			default:
				$path_file=Mage::getBaseUrl('media').'tmp/orderupload/icons/document.png';
				break;
		}
		
		return $path_file;
   }
   
   public function switchImagesExt($productid,$nameImage)
   {
   	$dir_file=Mage::getBaseDir('media').DS.'tmp'.DS.'orderupload'.DS.$productid.DS.$nameImage;
   	$part=pathinfo($dir_file);
   
   	switch ($part['extension'])
   	{
   		case 'doc':
   		case 'docx':
   			$path_file=Mage::getBaseUrl('media').'tmp/orderupload/icons/doc.png';
   			break;
   		case 'xls':
   		case 'xlsx':
   			$path_file=Mage::getBaseUrl('media').'tmp/orderupload/icons/xls.png';
   			break;
   		case 'zip':
   		case 'rar':
   			$path_file=Mage::getBaseUrl('media').'tmp/orderupload/icons/zip.png';
   			break;
   		case 'txt':
   			$path_file=Mage::getBaseUrl('media').'tmp/orderupload/icons/txt.png';
   			break;
   		case 'pdf':
   			$path_file=Mage::getBaseUrl('media').'tmp/orderupload/icons/pdf.png';
   			break;
   		case 'jpg':
   		case 'png':
   		case 'jpeg':
   		case 'gif':
   		case 'ico':
   		case 'btm':
   			$path_file=Mage::getBaseUrl('media').'tmp/orderupload/'.$productid.'/'.$nameImage;
   			break;
   		default:
   			$path_file=Mage::getBaseUrl('media').'tmp/orderupload/icons/document.png';
   			break;
   	}
   
   	return $path_file;
   }
   
  	public function checkProduct($items,$productid)
  	{
  		$prodId=array();
  		foreach($items as $item)
  		{
  			$data_item=$item->getData();
  			//Zend_Debug::dump($data['set_product_id']);exit();
  			if($productid == intval($data_item['set_product_id']))
  				$prodId[]=$productid;
  		}
  		
  		//Zend_Debug::dump($prodId);exit();
  		if(empty($prodId))
  			return false;
  		else
  			return true;
  		
  	}
	
	public function integrateOrderUpload()
  	{
		$product = Mage::registry('current_product');
        $attributes = $product->getAttributes();
        $storeId = Mage::app()->getStore()->getStoreId();
		$product_id = $product->getId();
		$attribute = Mage::getResourceModel('catalog/product')->getAttributeRawValue($product_id, Mage::getStoreConfig('orderupload/general/attr_code', $storeId), $storeId);
		if($attribute == 1){
			$value='<div class="box_upload">';
			$value.='<p>'.Mage::helper('orderupload')->__('Text Info').'</p>';
			$value.='<a class="show_upload"  onclick="';
			$value.="return showFormUpload('upload_files_nbm')";
			$value.='"';
			$value.=' href="#">'.Mage::helper('orderupload')->__('Click Here').'</a>';
			
			if(Mage::getStoreConfig('orderupload/general/remove_all')){
				$value .= '<a href="#" onclick="return removeAll()" class="show_upload upload_delete_all">Remove All</a>';
			}
			
			$value.='<br/>';
			$value.='</div>';
			
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
					$check_image=$this->checkProduct($items,$productid);
					
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
							$path_file=$this->switchImages($productid,$data_item);
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
		
		return $value;
	}
   
}