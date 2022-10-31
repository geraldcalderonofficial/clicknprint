<?php

class ME_Newsleteremail_Adminhtml_AutocancelController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Return some checking result
     *
     * @return void
     */
    public function checkAction()
    {
        $result = Mage::getModel('autocancel/cron')->autoCancel();
        Mage::app()->getResponse()->setBody($result);
    }
}