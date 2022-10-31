<?php
class NextBits_FormulaCSVPricing_Helper_Data extends Mage_Core_Helper_Abstract
{
		public function getSystemConfig($attribute)
		{
			return Mage::getStoreConfig('formulacsvpricing/general/'.$attribute);
		}
		
		public function isFormulaPricingEnable(){
			$globalStatus = Mage::getStoreConfig('formulacsvpricing/general/enabled');
			$status = 0;
			if($globalStatus == 1){				
				$status = Mage::registry('current_product')->getFormulaCsvEnable(); 
			}
			return $status;
		}
}