<?php
 
class NextBits_FormulaCSVPricing_Model_Adminhtml_System_Config_Source_Changeprice
{
   
	public function toOptionArray()
   {
       $_changeprice = array(
           array('value' => '0', 'label' => 'On Button Click'),
           array('value' => '1', 'label' => 'On The Fly'),
       );
 
       return $_changeprice;
   }
}

