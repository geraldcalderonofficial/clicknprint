<?php
class NextBits_SelectedOptionsSummary_Model_Observer extends Varien_Object
{
	public function prepareLayoutBefore(Varien_Event_Observer $observer)
	{
		if (!Mage::helper('selectedoptionssummary')->isJqueryEnabled()) {
           return $this;
		}
		
       /* @var $block Mage_Page_Block_Html_Head */
       $block = $observer->getEvent()->getBlock();

       if ("head" == $block->getNameInLayout()) {
           foreach (Mage::helper('selectedoptionssummary')->getFiles() as $file) {
               $block->addJs(Mage::helper('selectedoptionssummary')->getJQueryPath($file));
           }
       }
       return $this;
	}
	public function updateLayout(Varien_Event_Observer $observer){
		if(Mage::getStoreConfig('selectedoptionssummary/general/active') != '1'){
			return false;
		}
		$currentProduct = Mage::registry('current_product');
		if(!is_object($currentProduct )){
			return false;
		}
		if($currentProduct->getShowStickysidebar() != '1'){
			return false;
		}			
		/* echo ($currentProduct->getTypeId());exit; */
		$template = '<reference name="root">
				<action method="setTemplate"><template>page/2columns-right.phtml</template></action>
			</reference>';
		$observer->getEvent()->getLayout()->getUpdate()->addUpdate($template );
		$productType = $currentProduct->getTypeId();
		
			if( $productType == 'bundle'){
			
				$sidebarBlock = '<reference name="right">
						<action method="unsetChildren"></action>
						<remove name="sale.reorder.sidebar" />
						<block type="catalog/product_view" name="sort_selected_options_summary" template="selectedoptionssummary/catalog/product/bundle_summary.phtml">
						 <block type="catalog/product_view" name="product.info.options.wrapper.bottom-11" as="product.info.options.wrapper.bottom-11" template="catalog/product/view/options/wrapper/bottom.phtml" translate="label">
							<label>Bottom Block Options Wrapper</label>
							<action method="insert"><block>product.tierprices</block></action>
							<block type="catalog/product_view" name="product.clone_prices" as="prices" template="catalog/product/view/price_clone.phtml"/>
							<action method="append"><block>product.info.addtocart</block></action>
							<action method="append"><block>product.info.addto</block></action>
						</block>
						</block>
					</reference>';
			}else{	
			
				$sidebarBlock = '<reference name="right">
						<action method="unsetChildren"></action>
						<remove name="sale.reorder.sidebar" />
						<block type="catalog/product_view" name="sort_selected_options_summary" template="selectedoptionssummary/catalog/product/simple_summary.phtml">
						 <block type="catalog/product_view" name="product.info.options.wrapper.bottom-11" as="product.info.options.wrapper.bottom-11" template="catalog/product/view/options/wrapper/bottom.phtml" translate="label">
							<label>Bottom Block Options Wrapper</label>
							<action method="insert"><block>product.tierprices</block></action>
							<block type="catalog/product_view" name="product.clone_prices" as="prices" template="catalog/product/view/price_clone.phtml"/>
							<action method="append"><block>product.info.addtocart</block></action>
							<action method="append"><block>product.info.addto</block></action>
						</block>
						</block>
					</reference>';
			}
		$observer->getEvent()->getLayout()->getUpdate()->addUpdate($sidebarBlock );	
	}
}