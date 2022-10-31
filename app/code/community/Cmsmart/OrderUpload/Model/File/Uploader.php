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
 * @package     Mage_Core
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Core file uploader model
 *
 * @category   Mage
 * @package    Mage_Core
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Cmsmart_OrderUpload_Model_File_Uploader extends Varien_File_Uploader
{
    /**
     * Used to save uploaded file into destination folder with
     * original or new file name (if specified)
     *
     * @param string $destinationFolder
     * @param string $newFileName
     * @access public
     * @return void|bool
     */
	 
	protected function _moveFile($tmpPath, $destPath)
    {
        return move_uploaded_file($tmpPath, $destPath);
    }
	
    public function save($destinationFolder, $newFileName = null)
    {
    	$productid = Mage::app()->getRequest()->getParam('productid');
    	//Zend_Debug::dump($postData);exit();
    	
        $this->_validateFile();
		
        if ($this->_allowCreateFolders) {
            $this->_createDestinationFolder($destinationFolder);
        }

        if (!is_writable($destinationFolder)) {
            throw new Exception('Destination folder is not writable or does not exists.');
        }

        $this->_result = false;

        $destinationFile = $destinationFolder;
        $fileName = isset($newFileName) ? $newFileName : $this->_file['name'];
        $fileName = self::getCorrectFileName($fileName);
        if ($this->_enableFilesDispersion) {
            $fileName = $this->correctFileNameCase($fileName);
            $this->setAllowCreateFolders(true);
            $this->_dispretionPath = self::getDispretionPath($fileName,$productid);
            $destinationFile.= $this->_dispretionPath;
            
            //Zend_Debug::dump($destinationFile);exit();
            $this->_createDestinationFolder($destinationFile);
        }

        if ($this->_allowRenameFiles) {
            $fileName = self::getNewFileName(self::_addDirSeparator($destinationFile) . $fileName);
        }
		
        // file name in full path
        $nicename=$fileName;
        
        $destinationFile = self::_addDirSeparator($destinationFile) . $fileName;

        $this->_result = $this->_moveFile($this->_file['tmp_name'], $destinationFile);

        if ($this->_result) {
            chmod($destinationFile, 0777);
            if ($this->_enableFilesDispersion) {
                $fileName = str_replace(DIRECTORY_SEPARATOR, '/',
                    self::_addDirSeparator($this->_dispretionPath)) . $fileName;
            }
            $this->_uploadedFileName = $fileName;
            $this->_uploadedFileDir = $destinationFolder;
            $this->_result = $this->_file;
            $this->_result['path'] = $destinationFolder;
            //$this->_result['dirpath']=$destinationFolder.DIRECTORY_SEPARATOR.$productid.DIRECTORY_SEPARATOR.$nicename;
            $this->_result['file'] = $fileName;
            $this->_result['label']= $nicename;
			
            // copy data in session
            $obj_getcolect=Mage::getSingleton('core/session')->getObjProducts();
            
            if(!is_object($obj_getcolect))
            {
            	$item = new Varien_Object();
            	$item->setProductId=$productid;
            	$item->setFiles=$this->_result;
            	$item->setComment = $_FILES['descriptions'];
            	
            	
            	$obj_setcolect = new Varien_Data_Collection();
            	$obj_setcolect->addItem($item);
            	
            	Mage::getSingleton('core/session')->setObjProducts($obj_setcolect);
            }
            else
            {
            	$item = new Varien_Object();
            	$item->setProductId=$productid;
            	$item->setFiles=$this->_result;
            	$item->setComment = '';
				$item->setComment = $_FILES['descriptions'];
            	$obj_getcolect->addItem($item);
            }
            
            
            $this->_afterSave($this->_result);
        }

        return $this->_result;
    }
    
    private function _createDestinationFolder($destinationFolder)
    {
    	//Zend_Debug::dump($destinationFolder);exit();
    	if (!$destinationFolder) {
    		return $this;
    	}
    
    	if (substr($destinationFolder, -1) == DIRECTORY_SEPARATOR) {
    		$destinationFolder = substr($destinationFolder, 0, -1);
    	}
    
    	//Zend_Debug::dump($destinationFolder);exit();
    
    	if (!(@is_dir($destinationFolder) || @mkdir($destinationFolder, 0777, true))) {
    		throw new Exception("Unable to create directory '{$destinationFolder}'.");
    	}
    	return $this;
    }
    
    static public function getDispretionPath($fileName,$productid)
    {
    	//Zend_Debug::dump($productid);exit();
    	
    	$char = 0;
    	$dispretionPath = DIRECTORY_SEPARATOR.$productid;
    	/*
    	while (($char < 2) && ($char < strlen($fileName))) {
    		if (empty($dispretionPath)) {
    			$dispretionPath = DIRECTORY_SEPARATOR
    			. ('.' == $fileName[$char] ? '_' : $fileName[$char]);
    		} else {
    			$dispretionPath = self::_addDirSeparator($dispretionPath)
    			. ('.' == $fileName[$char] ? '_' : $fileName[$char]);
    		}
    		$char ++;
    	}
    	*/
    	//Zend_Debug::dump($dispretionPath);exit();
    	return $dispretionPath;
    }
    
}
