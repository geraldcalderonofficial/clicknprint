<?php
class ME_Newsleteremail_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        Mage::getModel('autocancel/cron')->autoCancel();
        die("abc");
    }
}