<?php
/**
 * Paytabs payment gateway
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so you can be sent a copy immediately.
 *
 *
 * @category Ras
 * @package    Ras_Paytabs
 * @copyright  Copyright (c) 2013 Paytabs
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Ras_Paytabs_Model_Server extends Mage_Payment_Model_Method_Abstract
{
    protected $_code  = 'paytabs_server';

    protected $_isGateway               = true;
    protected $_canAuthorize            = true;
    protected $_canCapture              = true;
    protected $_canCapturePartial       = false;
    protected $_canRefund               = false;
    protected $_canVoid                 = true;
    protected $_canUseInternal          = false;
    protected $_canUseCheckout          = true;
    protected $_canUseForMultishipping  = false;

    protected $_formBlockType = 'paytabs/server_form';
    protected $_paymentMethod = 'server';
    protected $_infoBlockType = 'paytabs/payment_info';

    protected $_order;
    
    protected $_paymentUrl = '';
    protected $_paypageStatus = false;
    public $PTauthentication = true;
    protected $PTHost = "https://www.paytabs.com";

    /**
     * Get order model
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        if (!$this->_order) {
            $paymentInfo = $this->getInfoInstance();
            $this->_order = Mage::getModel('sales/order')
                            ->loadByIncrementId($paymentInfo->getOrder()->getRealOrderId());
        }
        return $this->_order;
    }
    
    /**
     * Grand total getter
     *
     * @return string
     */
    private function _getAmount()
    {
        $total = $this->getOrder()->getGrandTotal();
        return $total;
    }

    /**
     * Get Customer Id
     *
     * @return string
     */
    public function getMerchantEmail()
    {
        $merchant_email = Mage::getStoreConfig('payment/' . $this->getCode() . '/merchant_email');            
        return $merchant_email;
    }

    public function getSecretKey()
    {
        $secret_key = Mage::getStoreConfig('payment/' . $this->getCode() . '/secret_key');
        return $secret_key;            
    }

    public function validate()
    {   
        return true;
    }
    
    public function getOrderPlaceRedirectUrl()
    {
        $url = Mage::getUrl('paytabs/' . $this->_paymentMethod . '/redirect');
        if(!$url) {
            $url = $this->PTHost.'/apiv2/create_pay_page';
        }
        return $url;
    }
    
    //Get 3 Digit ISO Code for Country
	public function _getISO3Code($szISO2Code) 
	{
		$boFound = false; 
		$nCount = 1; 

		$collection = Mage::getModel('directory/country_api')->items(); 

		while ($boFound == false && 
		$nCount < count($collection)) 
		{ 
		$item = $collection[$nCount]; 
		if($item['iso2_code'] == $szISO2Code) 
		{ 
		$boFound = true; 
		$szISO3Code = $item['iso3_code']; 
		} 
		$nCount++; 
		} 

		return $szISO3Code; 
	}
        
        public function PT_validatesecretkey() {
            $authentication_URL = $this->PTHost."/apiv2/validate_secret_key";
            
            $fields = array(
                'merchant_email' => $this->getMerchantEmail(),
                'secret_key' => $this->getSecretKey()
            );
            $fields_string = "";
            foreach($fields as $key=>$value) {
                $fields_string .= urlencode($key).'='.urlencode($value).'&'; 
            }
            $fields_string = substr($fields_string, 0, strrpos($fields_string, '&'));
            
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$authentication_URL);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            $ch_result = curl_exec($ch);
            $ch_error = curl_error($ch); 
            
            $dec = json_decode($ch_result,true);
            return $dec;
        }
	
    /**
     * prepare params array to send it to gateway page via POST
     *
     * @return array
     */
    public function getFormFields() {
        //Perform Authentication
        $auth = $this->PT_validatesecretkey();
        if (!$auth) {
            $this->_PTauthentication = false;
        }

        $secret_key = $this->getSecretKey();
        $merchant_email = $this->getMerchantEmail();
        Mage::getSingleton('core/session')->setSecretKey($secret_key);
        Mage::getSingleton('core/session')->setMerchantEmail($merchant_email);

        $fieldsArr = array();

        $paymentInfo = $this->getInfoInstance();
        $lengs = 0;

        $serverip = $_SERVER['SERVER_ADDR'];
        $customerip = $_SERVER['REMOTE_ADDR'];

        //Language Configuration
        $languageArray_arabic = array("ar_AE", "ar_BH", "ar_DZ", "ar_EG", "ar_IQ", "ar_JO", "ar_KW", "ar_LB", "ar_LY", "ar_MA", "ar_OM", "ar_QA", "ar_SA", "ar_SD", "ar_SY", "ar_TN", "ar_YE");
        $language_code = "English";
        $store_lang = Mage::app()->getLocale()->getLocaleCode();
        if(in_array($store_lang, $languageArray_arabic)) {
            $language_code = "Arabic";
        }

        $current_currency_code = Mage::app()->getStore()->getCurrentCurrencyCode();
        $returnurl = Mage::getUrl('paytabs/' . $this->_paymentMethod . '/response', array('_secure' => true));
        $orderid = $paymentInfo->getOrder()->getRealOrderId();

        $shipping_amount = $paymentInfo->getOrder()->getShippingAmount();
        $discount_amount = abs($paymentInfo->getOrder()->getDiscountAmount());
        //	$orderDetail = Mage::getModel('sales/order')->loadByIncrementId($orderid); 	
        $order = Mage::getModel('sales/order')->loadByIncrementID($orderid);
        $this->updateStatus(Mage_Sales_Model_Order::STATE_NEW);
        $items = $order->getAllItems();
        $itemcount = count($items);
        $name = array();
        $unitPrice = array();
        $sku = array();
        $ids = array();
        $qty = array();
        $sumofproductprices = 0;
        foreach ($items as $itemId => $item) {
            if ($item->getQtyToInvoice() !== 0) {
                $name[] = $item->getName();
                $unitPrice[] = $item->getPrice();
                $sku[] = $item->getSku(); //Description of Product
                $ids[] = $item->getProductId();
                $qty[] = $item->getQtyToInvoice();
                $sumofproductprices += $item->getQtyToInvoice() * $item->getPrice();
            }
        }
        $othercharges = $this->_getAmount()+$discount_amount - $sumofproductprices;
        $amount_to_sent = $sumofproductprices + $othercharges;
//        $othercharges = abs($othercharges + $shipping_amount);
        $categoryName = '';
        $categoryNames = 'Mobile';
        foreach ($ids as $ID) {
            $product = Mage::getModel('catalog/product')->load($ID);
            $categoryIds[] = $product->getCategoryIds();
            $_category = Mage::getModel('catalog/category')->load($categoryIds[0][0]);
            $categoryNames = $_category->getName();
//                            $categoryNames = Mage::getModel('catalog/category')->load($categoryIds[0]);
            break;
        }

        $b_address = $order->getBillingAddress()->getData();
        $s_address = ($order->getShippingAddress()) ? $order->getShippingAddress()->getData() : $order->getBillingAddress()->getData();

        $price_str_Arr = implode(" || ", $unitPrice);
        $product_str_Arr = implode(" || ", $name);
        $quantity_str_Arr = implode(" || ", $qty);
        $shipping_method = $order->getShippingMethod();
        $customer_name = $b_address['firstname'] . " " . $b_address['lastname']; //used for reference
        $site_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
        $fields = array(
            'merchant_email' => $this->getMerchantEmail(),
            'secret_key' => $secret_key,
            'cc_first_name' => $b_address['firstname'],
            'cc_last_name' => $b_address['lastname'],
            'phone_number' => $b_address['telephone'],
            'cc_phone_number' => $b_address['telephone'],
            'billing_address' => $b_address['street'],
            'city' => $b_address['city'],
            'state' => (empty($b_address['region']))?"N/A":$b_address['region'],
            'postal_code' => (empty($b_address['postcode']))?"0000":$b_address['postcode'],
            'country' => $this->_getISO3Code($b_address['country_id']), //$country,
            'email' => $b_address['email'],
            'amount' => $amount_to_sent,
            'other_charges' => $othercharges,
            'discount' => $discount_amount,
            'currency' => $current_currency_code,
            'title' => ($customer_name != "") ? $customer_name : $orderid,
            'ip_customer' => $customerip,
            'ip_merchant' => $serverip,
            'site_url' => rtrim($site_url, '/'),
            'return_url' => $returnurl,
            'address_shipping' => $s_address['street'],
            'city_shipping' => $s_address['city'],
            'state_shipping' => (empty($s_address['region']))?"N/A":$s_address['region'],
            'postal_code_shipping' => (empty($b_address['postcode']))?"0000":$s_address['postcode'],
            'country_shipping' => $this->_getISO3Code($s_address['country_id']),
            'quantity' => $quantity_str_Arr,
            'unit_price' => $price_str_Arr,
            'products_per_title' => $product_str_Arr,
            'ChannelOfOperations' => 'ChannelOfOperations',
            'ProductCategory' => $categoryNames,
            'ProductName' => $product_str_Arr,
            'ShippingMethod' => $shipping_method,
            'DeliveryType' => 'normal',
            'CustomerId' => $b_address['telephone'],
            'cms_with_version' => "magento-" . Mage::getVersion(),
            'msg_lang' => $language_code,
            'reference_no' => $orderid
        );
        $fields_string = "";
        foreach ($fields as $key => $value) {
            $fields_string .= urlencode($key) . '=' . urlencode($value) . '&';
        }
        $fields_string = substr($fields_string, 0, strrpos($fields_string, '&'));
//                $fields_string = urlencode($fields_string);
//                print_r($fields);
        $gateway_url = $this->getPaytabsCreatePayPageUrl();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $gateway_url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $ch_result = curl_exec($ch);
        $ch_error = curl_error($ch);
        Mage::log($ch_result);
        //curl_getinfo($ch);
        //curl_close($ch);
        $dec = json_decode($ch_result, true);
        $errorMessage = "";
        if (isset($dec['response_code']) && $dec['response_code'] == "4012") {
            $this->_paymentUrl = $dec['payment_url'];
            $this->_paypageStatus = true;
            return;
        } else {
            switch ($dec['response_code']) {
                case "4001":
                    $errorMessage = "Variable not found.";
                    break;
                case "4002":
                    $errorMessage = "Invalid Credentials.";
                    break;
                case "4007":
                    $errorMessage = "Missing parameter.";
                    break;
                case "4012":
                    $errorMessage = "Pay Page is created. User must go to the page to complete the payment.";
                    break;
                case "0404":
                    $errorMessage = "You don't have permissions to create an Invoice.";
                    break;
                default:
                    $errorMessage = "Something Went Wrong with Payment Information";
                    break;
            }

            Mage::getSingleton('core/session')->addError(Mage::helper('core')->__('Something went wrong. Please Contact the Website Administrator for more information.'));
            Mage::log($errorMessage);
            return;
        }

        //return;
    }

    public function statusOfPaypage(){
        return $this->_paypageStatus;
    }
    /**
     * Get url of Paytabs Payment
     *
     * @return string
     */
    public function getPaytabsCreatePayPageUrl()
    {
		// 1 - Test
		// 2 - Live
        /*
         * if( Mage::getStoreConfig('payment/' . $this->getCode() . '/environment')==1 ){
			$url = "http://paytabs.com/api/create_pay_page";
            } else 
         * 
         * 
         */
        $url = $this->PTHost."/apiv2/create_pay_page";
         return $url;
         
    }
    
    public function getPaytabsTransactionUrl()
    {
         /*if (!$this->_paymentUrl) {
             $this->_paymentUrl = $this->PTHost."/api/create_pay_page";
         }*/
         return $this->_paymentUrl;
    }

    /**
     * Get debug flag
     *
     * @return string
     */
    public function getDebug()
    {
        return Mage::getStoreConfig('payment/' . $this->getCode() . '/debug_flag');
    }

    public function capture(Varien_Object $payment, $amount)
    {
        $payment->setStatus(self::STATUS_APPROVED)
            ->setLastTransId($this->getTransactionId());

        return $this;
    }

    public function cancel(Varien_Object $payment)
    {
        $payment->setStatus(self::STATUS_DECLINED)
            ->setLastTransId($this->getTransactionId());

        return $this;
    }

    /**
     * Return redirect block type
     *
     * @return string
     */
    public function getRedirectBlockType()
    {
        return $this->_redirectBlockType;
    }

    public function assignData($data)
    {
        //Mage::throwException(implode(',',$data));
        $result = parent::assignData($data);        
        /*if (is_array($data)) {
            $this->getInfoInstance()->setAdditionalInformation($key, isset($data[$key]) ? $data[$key] : null);
        }
        elseif ($data instanceof Varien_Object) {
            $this->getInfoInstance()->setAdditionalInformation($key, $data->getData($key));
        }*/
        return $result;
    }
    /**
     * Return payment method type string
     *
     * @return string
     */
    public function getPaymentMethodType()
    {
        return $this->_paymentMethod;
    }

    public function getReturnURLonError()
    {
        Mage::getSingleton('core/session')->addError(Mage::helper('core')->__('There was Error in the Transaction.'));
//        return Mage::app()->getFrontController()->getResponse()->setRedirect();
        return Mage::getUrl('checkout/cart');
    }
    
    public function afterSuccessOrder($response)
    {
		
        $orderId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
        $order = Mage::getModel('sales/order');
        $order->loadByIncrementId($orderId);

        $paymentInst = $order->getPayment()->getMethodInstance();

        $paymentInst->setStatus(self::STATUS_APPROVED)
                ->setLastTransId($orderId)
                ->setTransactionId($response['payment_reference']);

        $order->sendNewOrderEmail();
        if ($order->canInvoice()) {
            $invoice = $order->prepareInvoice();

            $invoice->register()->capture();
            Mage::getModel('core/resource_transaction')
                    ->addObject($invoice)
                    ->addObject($invoice->getOrder())
                    ->save();
        }
        $transaction = Mage::getModel('sales/order_payment_transaction');
        $transaction->setTxnId($response['payment_reference']);
        $transaction->setOrderPaymentObject($order->getPayment())
                ->setTxnType(Mage_Sales_Model_Order_Payment_Transaction::TYPE_CAPTURE);
        $transaction->save();
        $order_status = Mage::helper('core')->__('Payment is successful.');

        $order->addStatusToHistory(Mage_Sales_Model_Order::STATE_PROCESSING, $order_status);
        $order->save();
    }
    
    public function updateStatus($status = Mage_Sales_Model_Order::STATE_PENDING_PAYMENT){
        $orderId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
        $order = Mage::getModel('sales/order');
        $order->loadByIncrementId($orderId);
        $order->setState($status, true)->save();
    }
}
