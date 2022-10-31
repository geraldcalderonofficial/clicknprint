<?php
class NextBits_FormulaCSVPricing_Adminhtml_FormulacsvpricingController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		$pId = $this->getRequest()->getParam('pid');
		$optionId = $this->getRequest()->getParam('option_id');
		$storeId = $this->getRequest()->getParam('store_id');
		$csvModel =Mage::getModel('formulacsvpricing/formulacsvpricing')->getCollection();
		$csvModel->addFieldToFilter('product_id',$pId);
		$csvModel->addFieldToFilter('option_id',$optionId);
		$csvModel->addFieldToFilter('store_id',$storeId);
		$csvModel->getSelect()->limit(1);
		$csvpriceData =$csvModel->getData();
		$csvprice=$csvpriceData[0]['csv_price'];
		$jsonDecode=Mage::helper('core')->jsonDecode($csvprice);
		Mage::register('pricesheeet',$jsonDecode['pricesheet']);
		$this->renderLayout();
	}
}