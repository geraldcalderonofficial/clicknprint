<?php  
class NextBits_FormulaCSVPricing_Model_Observer
{
	public function loadProductBefore(Varien_Event_Observer $observer)
	{
		$product = $observer->getProduct();
		$helper= Mage::helper('formulacsvpricing');
		
		$enabledFormulaPricing = Mage::getStoreConfig('formulacsvpricing/general/enabled');
		if($enabledFormulaPricing == 1){
			$enableExtension = $product->getFormulaCsvEnable();	
		}else{
			$enableExtension = 0;
		}
		
		if($enableExtension==1)
		{
			$requiredAttribute = array('formula_csv_final','additional_variable','custom_variable_formula','assign_variable','option_values','extra_price_formula','min_input_setting','min_input_validation','max_input_setting','max_input_validation','custom_validation');
			foreach($requiredAttribute as $key=>$attribute)
			{
					$value = $product->getData($attribute);
					$value = trim($value);
					if(empty($value))
					{
						$config = $helper->getSystemConfig($attribute);
						$product->setData($attribute,$config);
					}
			}
			
		}
	}
}	