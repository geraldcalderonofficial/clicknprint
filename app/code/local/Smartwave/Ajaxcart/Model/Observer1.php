<?php
class Smartwave_Ajaxcart_Model_Observer extends Varien_Object
{

   public function prepareLayoutBefore(Varien_Event_Observer $observer)
   {
       return $this;
   }
   
   public function postdispatch(Varien_Event_Observer $event) {
		/* @var $controller Mage_Core_Controller_Varien_Action */
		$controller = $event->getControllerAction();
		if (!$controller->getRequest()->getHeader('X-Requested-With')) {
			return;
		}
		
		$param = array();
		$headers = Mage::app()->getRequest()->getParams();
		
		foreach ($headers as $headerName => $headerValue) {
			$headerName = strtolower($headerName);
			if (!preg_match('/tr(.*)/',$headerName,$regs))
				continue;
			$param[str_replace('_','.',$regs[1])] = $headerValue;
		}
		
		//orginal magento ajax request
		if (!count($param)) {
			return;
		}
		
		$layout = Mage::app()->getLayout();
		$blocks = array();
		
		foreach ($param as $blockName => $selector) {
			$temp = $layout->getBlock($blockName);
			$blocks[$blockName] = array(
				'selector'	=> $selector,
				'html'		=> ($temp)?$temp->toHtml():''
			);
		}
		echo json_encode($blocks);
		
		exit;
	}		
	public function updatePrice(Varien_Event_Observer $observer) {		
		$event = $observer->getEvent();		
		$quote_item = $event->getQuoteItem();		
		$product = $quote_item->getProduct();		
		$baseProductPrice = $product->getPrice();		
		$new_price  = $baseProductPrice;		
		$count = 1;			
		
		$item = $quote_item;
		if ($item->getParentItem()) {$item = $item->getParentItem();}
		$price = $item->getProduct()->getFinalPrice();
	
		foreach($quote_item->getBuyRequest()->getOptions() as $code => $option){
			$new_price = (float)$new_price * (float)$option;			
			if($count == 2) break;			
			$count++;		
		}
		
		$quote_item->setCustomPrice($new_price);		
		$quote_item->setOriginalCustomPrice($new_price);		
		$quote_item->getProduct()->setIsSuperMode(true);	
	}
}