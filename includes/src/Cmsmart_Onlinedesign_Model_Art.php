<?php

class Cmsmart_Onlinedesign_Model_Art extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('onlinedesign/art');
    }
}