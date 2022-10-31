<?php
class ME_Newsleteremail_Block_Statuses extends Mage_Core_Block_Html_Select
{
    /**
     * Statuses cache
     *
     * @var array
     */
    private $_statuses;

    /**
     * Flag whether to add group all option or no
     *
     * @var bool
     */
    protected $_addAllOption = true;

    /**
     * States that can be canceled
     */
    protected $_cancelableStatuses = array(
        Mage_Sales_Model_Order::STATE_NEW,
        Mage_Sales_Model_Order::STATE_PENDING_PAYMENT,
        Mage_Sales_Model_Order::STATE_PROCESSING,
    );

    /**
     * Retrieve order statuses
     */
    protected function _getStatuses($statusCode = null)
    {
        if (is_null($this->_statuses)) {
            $this->_statuses = array();
            $statuses = Mage::getSingleton('sales/order_config')->getStateStatuses($this->_cancelableStatuses);
            foreach ($statuses as $code => $label) {
                $this->_statuses[$code] = $label;
            }

            // Sort for human legibility
            natcasesort($this->_statuses);
        }

        if (!is_null($statusCode)) {
            return isset($this->_statuses[$statusCode]) ? $this->_statuses[$statusCode] : null;
        }

        return $this->_statuses;
    }

    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml()
    {
        if (!$this->getOptions()) {
            if ($this->_addAllOption) {
                $this->addOption('default', Mage::helper('autocancel')->__('--Please Select--'));
            }
            foreach ($this->_getStatuses() as $code => $label) {
                $this->addOption($code, $label);
            }
        }
        return parent::_toHtml();
    }

}
