<?php
class NextBits_FormulaCSVPricing_Block_Adminhtml_Catalog_Product_Tab 
extends Mage_Adminhtml_Block_Template
implements Mage_Adminhtml_Block_Widget_Tab_Interface {
 
    /**
     * Set the template for the block
     *
     */
    public function _construct()
    {
        parent::_construct();
         
        $this->setTemplate('formulacsvpricing/catalog/product/tab/csv.phtml');
    }
     
    /**
     * Retrieve the label used for the tab relating to this block
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Upload CSV- Formula Pricing');
    }
     
    /**
     * Retrieve the title used by this tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Click here to view your custom tab content');
    }
     
    /**
     * Determines whether to display the tab
     * Add logic here to decide whether you want the tab to display
     *
     * @return bool
     */
    public function canShowTab()
    {
		if(Mage::registry('product')->getTypeId()=='simple') 
        return true;
    }
     
    /**
     * Stops the tab being hidden
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }
	
	public function getStores()
    {
        $stores = $this->getData('stores');
        if (is_null($stores)) {
            $stores = Mage::getModel('core/store')
                ->getResourceCollection()
                ->setLoadDefault(true)
                ->load();
            $this->setData('stores', $stores);
        }
 
        return $stores;
    }     
	
	public function getCsvPathFile($Id,$optId,$storeId)
	{
		$resource = Mage::getSingleton('core/resource');
		$writeconnection = $resource->getConnection('core_write');
		$table = $resource->getTableName('formulacsvpricing/formulacsvpricing');
		$query = "select * from $table where product_id='".$Id."' and store_id=".$storeId." and option_id=".$optId;
		$res = $writeconnection->fetchRow($query); 
		if(!empty($res))
		{
			return "<a target='_black' href='".Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'media'.DS.'formulacsvpricing'.$res['file_name']."' >".$this->__('Download')."</a>";
		}else
		{	return '';
		}

	}
    
	      

}