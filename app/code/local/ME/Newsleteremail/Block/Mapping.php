<?php

class ME_Newsleteremail_Block_Mapping extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    protected $_methodRenderer;

    protected $_statusRenderer;

    protected $_periodRenderer;

    /**
     * Retrieve group column renderer
     */
    protected function _getMethodRenderer()
    {
        if (!$this->_methodRenderer) {
            $this->_methodRenderer = $this->getLayout()->createBlock('autocancel/methods', '', array('is_render_to_js_template' => true));
            $this->_methodRenderer->setClass('method_select');
            $this->_methodRenderer->setExtraParams('style="width:120px"');
        }
        return $this->_methodRenderer;
    }

    /**
     * Retrieve group column renderer
     */
    protected function _getStatusRenderer()
    {
        if (!$this->_statusRenderer) {
            $this->_statusRenderer = $this->getLayout()->createBlock('autocancel/statuses', '', array('is_render_to_js_template' => true));
            $this->_statusRenderer->setClass('status_select');
            $this->_statusRenderer->setExtraParams('style="width:120px"');
        }
        return $this->_statusRenderer;
    }

    /**
     * Retrieve group column renderer
     */
    protected function _getPeriodRenderer()
    {
        if (!$this->_periodRenderer) {
            $this->_periodRenderer = $this->getLayout()->createBlock('autocancel/periods', '', array('is_render_to_js_template' => true));
            $this->_periodRenderer->setClass('period_select');
            $this->_periodRenderer->setExtraParams('style="width:120px"');
        }
        return $this->_periodRenderer;
    }

    /**
     * Prepare to render
     */
    protected function _prepareToRender()
    {
        $this->addColumn('method', array(
            'label' => Mage::helper('autocancel')->__('Payment Method'),
            'renderer' => $this->_getMethodRenderer(),
        ));
        $this->addColumn('status', array(
            'label' => Mage::helper('autocancel')->__('Order Status'),
            'renderer' => $this->_getStatusRenderer(),
        ));
        $this->addColumn('period', array(
            'label' => Mage::helper('autocancel')->__('Auto-Cancel Period'),
            'renderer' => $this->_getPeriodRenderer(),
        ));
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('autocancel')->__('Add Rule');
    }

    /**
     * Prepare existing row data object
     *
     * @param Varien_Object
     */
    protected function _prepareArrayRow(Varien_Object $row)
    {
        $row->setData('option_extra_attr_' . $this->_getMethodRenderer()->calcOptionHash($row->getData('method')), 'selected="selected"');
        $row->setData('option_extra_attr_' . $this->_getStatusRenderer()->calcOptionHash($row->getData('status')), 'selected="selected"');
        $row->setData('option_extra_attr_' . $this->_getPeriodRenderer()->calcOptionHash($row->getData('period')), 'selected="selected"');
    }

}
