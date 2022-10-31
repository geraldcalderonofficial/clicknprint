<?php
class ME_Newsleteremail_Block_Periods extends Mage_Core_Block_Html_Select
{
    /**
     * Customer groups cache
     *
     * @var array
     */
    private $_periods;

    /**
     * Flag whether to add group all option or no
     *
     * @var bool
     */
    protected $_addAllOption = true;

    /**
     * Retrieve allowed customer groups
     *
     * @param int $periodId  return name by customer group id
     * @return array|string
     */
    protected function _getPeriods($periodId = null)
    {
        if (is_null($this->_periods)) {
            $this->_periods = array();
            $collection = Mage::getModel('autocancel/source_periods')->toOptionArray();
            foreach ($collection as $key => $value) {
                $this->_periods[$value['value']] = $value['label'];
            }
        }

        if (!is_null($periodId)) {
            return isset($this->_periods[$periodId]) ? $this->_periods[$periodId] : null;
        }

        return $this->_periods;
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
            foreach ($this->_getPeriods() as $periodId => $classLabel) {
                $this->addOption($periodId, $classLabel);
            }
        }
        return parent::_toHtml();
    }

}
