<?php 
class NextBits_SelectedOptionsSummary_Block_Selectedoptions extends Mage_Bundle_Block_Catalog_Product_View_Type_Bundle_Option
{
	public function getOptionDescription($_selection, $includeContainer = true)
	{
		$price = $this->getProduct()->getPriceModel()->getSelectionPreFinalPrice($this->getProduct(), $_selection);
		$this->setFormatProduct($_selection);
		$priceTitle = $this->escapeHtml($_selection->getName());

		$priceTitle .= ' &nbsp; ' . ($includeContainer ? '<span class="price-notice">' : '')
		. '+' . $this->formatPriceString($price, $includeContainer)
		. ($includeContainer ? '</span>' : '');
		return  $priceTitle; 
	}
}