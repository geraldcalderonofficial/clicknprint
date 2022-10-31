<?php

class Cmsmart_OrderUpload_GalleryController extends Mage_Core_Controller_Front_Action
{
    public function uploadAction()
    {
        try {
		$uploads = $_FILES["uploads"];
		// print_r($_FILES["image"]); die;
		// print_r($_FILES["uploads"]); die;
		$descriptions = @$_POST["descriptions"];
	if (count($uploads['name'])>0){
		foreach ($uploads['name'] as $key => $name) {			
			if ($uploads['error'][$key] === UPLOAD_ERR_OK) {
		
		
			$upl = array();
				$upl['name'] = @$uploads["name"][$key];
				$upl['error'] = @$uploads["error"][$key];
				$upl['descriptions'] = 
				$upl['size'] = @$uploads["size"][$key];
				$upl['type'] = @$uploads["type"][$key]; // could be bogus!!! Users and browsers lie!!!
				$upl['tmp_name']  = @$uploads["tmp_name"][$key];
		
			// register product in registry
        	$productid = Mage::app()->getRequest()->getParam('productid');
			$_FILES["image"] = $upl;
			$_FILES["descriptions"] = @$descriptions[$key];
			
            // $uploader = new Cmsmart_OrderUpload_Model_File_Uploader($upl);
            $uploader = new Cmsmart_OrderUpload_Model_File_Uploader('image');
        	//Mage::getSingleton('orderupload/uploader');
			
			// get extension allow in config of module
            $param_extension = Mage::getStoreConfig('orderupload/general/file_extension');
            $extension=explode(',',$param_extension);
            
            //$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png','txt','exe','docx','zip','exe','flv'));
            $uploader->setAllowedExtensions($extension);
            		
            //$uploader->addValidateCallback('catalog_product_image',
                //Mage::helper('catalog/image'), 'validateUploadFile');
            $uploader->setAllowRenameFiles(true);
            
            // create folder seperate in folders default
            $uploader->setFilesDispersion(true);
			/*
            $result = $uploader->save(
                Mage::getSingleton('catalog/product_media_config')->getBaseTmpMediaPath()
            );
			*/
			$path_save=Mage::getBaseDir('media').DS.'tmp'.DS.'orderupload';
			$result = $uploader->save($path_save);
		
			//Zend_Debug::dump($result);exit();
			
            Mage::dispatchEvent('catalog_product_gallery_upload_image_after', array(
                'result' => $result,
                'action' => $this
            ));

			//print_r($result);die;
            /**
             * Workaround for prototype 1.7 methods "isJSON", "evalJSON" on Windows OS
             */
            $result['tmp_name'] = str_replace(DS, "/", $result['tmp_name']);
            $result['path'] = str_replace(DS, "/", $result['path']);

            //$result['url'] = Mage::getSingleton('catalog/product_media_config')->getTmpMediaUrl($result['file']);
            $result['url'] = Mage::getBaseUrl('media').'tmp/orderupload'.$result['file'];
            
            // get extension file
            $result['url_icon']=Mage::getBaseUrl('media').'tmp/orderupload/icons/';
            
            $path_dir=explode('/',$result['file']);
            $result['label']=$path_dir[2];
            
            $dir_file=Mage::getBaseDir('media').DS.'tmp'.DS.'orderupload'.DS.$path_dir[1].DS.$path_dir[2];
            $part=pathinfo($dir_file);
            $result['file_ext']=$part['extension'];
            
            $result['newname']=$result['file'];
            
            //$result['dirpath']=$result['path'].DIRECTORY_SEPARATOR.$productid.DIRECTORY_SEPARATOR.$result['newname'];
            $result['file'] = $result['file'] . '.tmp';
            $result['cookie'] = array(
                'name'     => session_name(),
                'value'    => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path'     => $this->_getSession()->getCookiePath(),
                'domain'   => $this->_getSession()->getCookieDomain()
            );
	}}}
	
        } catch (Exception $e) {
			echo $e->getMessage().'<br/>';
            $result = array(
                'error' => $e->getMessage(),
                'errorcode' => $e->getCode());
        }

		$this->getImagesAction();
        //$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
		
		
    }
	
    // function delete files
    public function deleteImageAction()
    {
    	$productid = Mage::app()->getRequest()->getParam('productid');
    	$file = Mage::app()->getRequest()->getParam('file');
    	
    	//$path_file=Mage::getBaseDir('media').DS.'tmp'.DS.'orderupload'.DS;
    	$obj_getcolect=Mage::getSingleton('core/session')->getObjProducts();
    	
    	$result=Mage::helper('orderupload')->__('Remove Fail !');
    	if(is_object($obj_getcolect))
    	{
    		$items=$obj_getcolect->getItems();
    		 
    		//Zend_Debug::dump($items);
    		foreach($items as $productItem=>$item)
    		{
    			$data_item=$item->getData();
    			//Zend_Debug::dump($data_item);exit();
    			if($productid == intval($data_item['set_product_id']))
    			{
    				// set comment
    				if($data_item['set_files']['label'] == $file)
    				{
    					$file=$data_item['set_files']['path'].DS.$productid.DS.$file;
    					if(file_exists($file))
    						unlink($file);
    					// remove item collection if save cart done
    					$obj_getcolect->removeItemByKey($productItem);
    					$result=Mage::helper('orderupload')->__('Remove done !');;
    				}
    			}
    		}
    	}
    	//Zend_Debug::dump($file);
    	echo $result;
		
    	exit();
    }
    
    
    // function add comment with images
    public function updateInfoAction()
    {
    	$productid = Mage::app()->getRequest()->getParam('productid');
    	$comment = Mage::app()->getRequest()->getParam('comment');
    	$label = Mage::app()->getRequest()->getParam('label');
    	
    	//echo $comment;
    	$result=Mage::helper('orderupload')->__('Updated Fail !');
    	// add comment to images
    	$obj_getcolect=Mage::getSingleton('core/session')->getObjProducts();
    	if(is_object($obj_getcolect))
    	{
    	
    		$items=$obj_getcolect->getItems();
    	
    		//Zend_Debug::dump($items);
    		foreach($items as $item)
    		{
    			$data_item=$item->getData();
    			//Zend_Debug::dump($data_item);exit();
    			if($productid == intval($data_item['set_product_id']))
    			{
    				// set comment
    				if($data_item['set_files']['label'] == $label)
    				{
    					$item->setComment=$comment;
    					$result=Mage::helper('orderupload')->__('Updated done !');
    				}	
    			}
    		}
    	}
    	
    	echo $result;
    	
    	exit();
    }
    
    // function delete files
    public function getImagesAction()
    {
    	$productid = Mage::app()->getRequest()->getParam('productid');
    	//$image = Mage::app()->getRequest()->getParam('image');
    	 
    	$obj_getcolect=Mage::getSingleton('core/session')->getObjProducts();
    	$value='';
    	
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
					$value.='<tr class="headings">';
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
    	 
    	//Zend_Debug::dump($value);
    	echo $value;
    	
    	exit();
    }
    
	/**
     * Retrieve adminhtml session model object
     *
     * @return Mage_Adminhtml_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('adminhtml/session');
    }
	
	public function deleteAllImageAction()
    {
    	$productid = Mage::app()->getRequest()->getParam('productid');
    	$file = Mage::app()->getRequest()->getParam('file');
    	
    	//$path_file=Mage::getBaseDir('media').DS.'tmp'.DS.'orderupload'.DS;
    	$obj_getcolect=Mage::getSingleton('core/session')->getObjProducts();
    	
    	$result=Mage::helper('orderupload')->__('Remove Fail !');
    	if(is_object($obj_getcolect))
    	{
    		$items=$obj_getcolect->getItems();
    		
    		foreach($items as $productItem=>$item)
    		{
    			$data_item=$item->getData();

    			if($productid == intval($data_item['set_product_id']))
    			{
					$file=$data_item['set_files']['path'].DS.$productid.DS.$file;
					if(file_exists($file))
						unlink($file);
					// remove item collection if save cart done
					$obj_getcolect->removeItemByKey($productItem);
					$result=Mage::helper('orderupload')->__('Remove done !');;
    			} 
    		}
    	}

    	echo $result;
		
    	exit();
    }
	
	/*
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('catalog/products');
    }
	*/
} // Class Mage_Adminhtml_Catalog_Product_GalleryController End
