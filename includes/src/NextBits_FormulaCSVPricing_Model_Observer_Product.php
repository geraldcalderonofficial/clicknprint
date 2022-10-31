<?php 
ini_set('auto_detect_line_endings', true);  
class NextBits_FormulaCSVPricing_Model_Observer_Product
{
	 static protected $_singletonFlag = false;
     public function formulacsvpricing(Varien_Event_Observer $observer)
    {
			$resource = Mage::getSingleton('core/resource');
			$writeconnection = $resource->getConnection('core_write');
			$table = $resource->getTableName('formulacsvpricing/formulacsvpricing');
			
			$product = $observer->getEvent()->getProduct();
			$Id =$product->getId();
			if (!self::$_singletonFlag) {
				self::$_singletonFlag = true;
				if ($this->_getRequest()->getPost()) {
						$removeFile=Mage::app()->getRequest()->getParam('formulacsvpricing_remove_file');
						
						if(isset($removeFile) && !empty($removeFile)){
							foreach($removeFile as $key=>$value){
								foreach($value as $_key=>$_value){
									if($_value=='on'){
										$writeconnection->query("delete from $table where product_id='".$product->getId()."' and store_id='".$_key."' and option_id=".$key);
									}
								}
							}
						}
						foreach($_FILES  as $key=>$value)
						{
							
							if(!empty($value['name'])){
								try{
			
								$keywithstore =str_replace('formulacsvpricing_option_csv_price_','',$key);
								$implode =explode('_',$keywithstore);
								$store = $implode[1];
								$nkey = $implode[0];
								$uploader = new Varien_File_Uploader($key);
								$uploader->setAllowedExtensions('csv');
								$uploader->setAllowRenameFiles(false);
								$uploader->setFilesDispersion(false);
								$path = Mage::getBaseDir('media') . DS.'formulacsvpricing'.DS.$product->getId().DS.$nkey.DS;
								$csvName = $value['name'];
								$uploader->save($path, $csvName);
								$filename=$path.$csvName;
								$data=$this->csv_to_array($filename,',');
								foreach($data as $key=>$value)
								{
									if($key =='')
									{
										unset($data[$key]);
									}
								}
								//get min and max value
								$minmax['minRow']=min(array_keys($data));
								$minmax['maxRow']=max(array_keys($data));
								$cols=array_keys($data[$minmax['minRow']]);
								$minmax['minCol']=min($cols);
								$minmax['maxCol']=max($cols);
								$temp['pricesheet']=$data;
								$max=-9999999;
								$min='';
								foreach($data as $sub){
									foreach($sub as $key=>$value)
									{
										if(empty($value))
											unset($sub[$key]);
									}
									$tempMax = max($sub);
									$tempMin = min($sub);
									if($min==''){
										$min=$tempMin;
									}
									if($tempMax > $max){
										$max = $tempMax;
									}
									if($tempMin < $min){
										$min = $tempMin;
									}
								}
								$minmax['minPrice']=$min;
								$minmax['maxPrice']=$max;
								$temp['minmax']=$minmax;
								$val['col']=$cols;
								$val['row']=array_keys($data);
								$temp['vals']=$val;
								//json encode
								$data=Mage::helper('core')->jsonEncode($temp);
								//assign data to csv_price attribute
								if($product){
								
									$resource = Mage::getSingleton('core/resource');
									$query = "select * from $table where product_id='".$Id."' and option_id=".$nkey." and store_id=".$store;
									$res = $writeconnection->fetchRow($query);
									if(empty($res))
									{
										$csvModel =Mage::getModel('formulacsvpricing/formulacsvpricing');
										$csvModel->setProductId($product->getId());
										$csvModel->setCsvPrice($data);
										$csvModel->setOptionId($nkey);
										$csvModel->setFName($csvName);
										$csvModel->setStoreId($store);
										$csvModel->setFileName(DS.$product->getId().DS.$nkey.DS.$csvName);
										$csvModel->save();
									}else
									{
										$csvModel =Mage::getModel('formulacsvpricing/formulacsvpricing')->load($res['id']);
										$csvModel->setCsvPrice($data);
										$csvModel->setFName($csvName);
										$csvModel->setStoreId($store);
										$csvModel->setFileName(DS.$product->getId().DS.$nkey.DS.$csvName);
										$csvModel->save();
									}

								}
								
								}catch (Exception $e) {
									//Mage::getSingleton('adminhtml/session')->addError('An error occurred while saving file');
								}
							}
							
						}
				}

		   }  
	  }
    /**
     * Shortcut to getRequest
     */
    protected function _getRequest()
    {
        return Mage::app()->getRequest();
    }
	// convert csv to array
	public function csv_to_array($filename='', $delimiter=',')
	{
			if(!file_exists($filename) || !is_readable($filename))
				return FALSE;
			$header = NULL;
			$data = array();
			if (($handle = fopen($filename, 'r')) !== FALSE)
			{
				while (($row = fgetcsv($handle, 100000, $delimiter)) !== FALSE)
				{
					if(!$header){
						$row = array_map('trim', $row);
						$header = $row;
					}	
					else{
						$key=trim($row[0]);
						unset($row[0]);
						unset($header[0]);
						$row = array_map('trim', $row);
						$data[$key] = array_combine($header, $row);
					}	
				}
				fclose($handle);
			}
		
		return $data;
	}
	

}
