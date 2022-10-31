<?php
class ME_Newsleteremail_Model_Observer {

    const XML_PATH_EMAIL_TEMPLATE = 'newsletter_alert_template';

    public function newsletteralert($observer){		
		if(!Mage::getStoreConfig('newsleteremail/settings/enabled'))			
			return;
		$eventname=$observer->getEvent()->getName();
		$subscriber=$observer->getEvent()->getSubscriber();
		$email=$subscriber->getEmail();
		$id=$subscriber->getId();		
		$emailtemplate=Mage::getModel('core/email_template')->loadDefault(self::XML_PATH_EMAIL_TEMPLATE);
		$sender=array();
		$sender['name'] = Mage::getStoreConfig('trans_email/ident_general/name');
		$sender['email'] = Mage::getStoreConfig('trans_email/ident_general/email');
		
		$bcc_emails_arr = explode(",", Mage::getStoreConfig('newsleteremail/settings/bcc_emails'));
		
		try {
			for($i = 0; $i < count($bcc_emails_arr); $i++) {
				$email_i = trim($bcc_emails_arr[$i]);
				$emailtemplate->sendTransactional(
					self::XML_PATH_EMAIL_TEMPLATE,
					$sender,
					$email_i, // email id of website/store admin; email1,email2
					'', // subject email to admin
					array('subscirber'=>$subscriber)
				);
			}
		} catch(Mage_Core_Exception $e){
			Mage::log($e->getMessage(),null,'newsletter.log');
		}
	}
}
?>