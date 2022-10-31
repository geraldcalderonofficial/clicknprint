<?php
/**
 * Cartin24
 * @category   Magento Extensions
 * @package    Cartin24_Deleteorders
 * @copyright  Copyright (c) 2015-2016 Cartin24. (http://www.Cartin24.com)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Cartin24_Deleteorders_Adminhtml_DeleteordersController extends Mage_Adminhtml_Controller_Action {

  protected function _initOrder(){
        $id 		= $this->getRequest()->getParam('order_id');
        $order 	= Mage::getModel('sales/order')->load($id);

        if (!$order->getId()) {
            $this->_getSession()->addError($this->__('This order is no longer exists.'));
            $this->_redirect('*/*/');
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return false;
        }
        Mage::register('sales_order', $order);
        Mage::register('current_order', $order);
        return $order;
   }
   
	public function deleteAction() {
		if($order = $this->_initOrder()) {
			try {
     		    $order->delete();
				if($this->_deleteOrder($this->getRequest()->getParam('order_id'))){
					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Order has been successfully deleted'));
					$this->_redirectUrl(Mage::helper('adminhtml')->getUrl('adminhtml/sales_order/index'));
				}
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('order_ids')));
			}
		}
		$this->_redirectUrl(Mage::helper('adminhtml')->getUrl('adminhtml/sales_order/index'));
	}
	
   public function massDeleteAction() {
        	$order_ids = $this->getRequest()->getParam('order_ids');
			if(!is_array($order_ids)) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select order(s)'));
        	} else {
            try {
                foreach ($order_ids as $order_id) {
						Mage::getModel('sales/order')->load($order_id)->delete()->unsetAll();
						$this->_deleteOrder($order_id);
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d order(s) are successfully deleted', count($order_ids)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        
		  $this->_redirectUrl(Mage::helper('adminhtml')->getUrl('adminhtml/sales_order/index'));
   }
   
	protected function _isAllowed() {
       return true;
   }    
	
	public function _deleteOrder($order_id){
		/*
		$resource 	= Mage::getSingleton('core/resource');
      $read 		= $resource->getConnection('core_read');
		
		$order_tbl      = $resource->getTableName('sales_flat_order_grid');
      $invoice_tbl    = $resource->getTableName('sales_flat_invoice_grid');
      $shipment_tbl   = $resource->getTableName('sales_flat_shipment_grid');
      $creditmemo_tbl = $resource->getTableName('sales_flat_creditmemo_grid');
		
		$sql = "DELETE FROM  " . $order_tbl . " WHERE entity_id = " . $order_id . ";";
      $read->query($sql);
      
		$sql = "DELETE FROM  " . $invoice_tbl . " WHERE order_id = " . $order_id . ";";
      $read->query($sql);
      
		$sql = "DELETE FROM  " . $shipment_tbl . " WHERE order_id = " . $order_id . ";";
      $read->query($sql);
      
		$sql = "DELETE FROM  " . $creditmemo_tbl . " WHERE order_id = " . $order_id . ";";
      $read->query($sql);
      */
 
		$write 							= Mage::getSingleton('core/resource')->getConnection('core_write');	
		$resource_tables			=	$write->fetchCol("SHOW TABLES");
		
		$table_sales_flat_creditmemo_grid		= Mage::getSingleton('core/resource')->getTableName('sales_flat_creditmemo_grid');
		$table_sales_flat_shipment_grid			= Mage::getSingleton('core/resource')->getTableName('sales_flat_shipment_grid');	
		$table_sales_flat_invoice_grid			= Mage::getSingleton('core/resource')->getTableName('sales_flat_invoice_grid');
		$table_sales_flat_order_grid				= Mage::getSingleton('core/resource')->getTableName('sales_flat_order_grid');
								
		$table_sales_flat_order 					= Mage::getSingleton('core/resource')->getTableName('sales_flat_order');						
		$table_sales_flat_creditmemo_comment	= Mage::getSingleton('core/resource')->getTableName('sales_flat_creditmemo_comment');
		$table_sales_flat_creditmemo_item		= Mage::getSingleton('core/resource')->getTableName('sales_flat_creditmemo_item');
		$table_sales_flat_creditmemo				= Mage::getSingleton('core/resource')->getTableName('sales_flat_creditmemo');
		$table_sales_flat_invoice_comment		= Mage::getSingleton('core/resource')->getTableName('sales_flat_invoice_comment');
		$table_sales_flat_invoice_item			= Mage::getSingleton('core/resource')->getTableName('sales_flat_invoice_item');
		$table_sales_flat_invoice					= Mage::getSingleton('core/resource')->getTableName('sales_flat_invoice');
		$table_sales_flat_quote_address_item	= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote_address_item');
		$table_sales_flat_quote_item_option	= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote_item_option');
		$table_sales_flat_quote						= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote');
		$table_sales_flat_quote_address			= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote_address');
		$table_sales_flat_quote_item				= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote_item');
		$table_sales_flat_quote_payment			= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote_payment');
		$table_sales_flat_shipment_comment		= Mage::getSingleton('core/resource')->getTableName('sales_flat_shipment_comment');
		$table_sales_flat_shipment_item			= Mage::getSingleton('core/resource')->getTableName('sales_flat_shipment_item');
		$table_sales_flat_shipment_track		= Mage::getSingleton('core/resource')->getTableName('sales_flat_shipment_track');
		$table_sales_flat_shipment					= Mage::getSingleton('core/resource')->getTableName('sales_flat_shipment');
		$table_sales_flat_order_address			= Mage::getSingleton('core/resource')->getTableName('sales_flat_order_address');
		$table_sales_flat_order_item				= Mage::getSingleton('core/resource')->getTableName('sales_flat_order_item');
		$table_sales_flat_order_payment			= Mage::getSingleton('core/resource')->getTableName('sales_flat_order_payment');
		$table_sales_flat_order_status_history= Mage::getSingleton('core/resource')->getTableName('sales_flat_order_status_history');					
		$table_log_quote								= Mage::getSingleton('core/resource')->getTableName('log_quote');
		$table_sales_flat_quote_shipping_rate=	Mage::getSingleton('core/resource')->getTableName('sales_flat_quote_shipping_rate');
				
		$query	=	null;
		$order 	= Mage::getModel('sales/order')->load($order_id);	
						
		if($order->increment_id){
			
			$incrementId = $order->increment_id;
			
			if(in_array($table_sales_flat_order,$resource_tables)){
				/*
				$query	=	'SELECT entity_id FROM '.$table_sales_flat_order.' WHERE increment_id="'.mysql_escape_string($incrementId).'"';
				$res1		=	$write->fetchAll($query);		
				*/										
			
				$query	=	'SELECT quote_id FROM '.$table_sales_flat_order.' WHERE entity_id="'.mysql_escape_string($order_id).'"';
				$res		=	$write->fetchAll($query);
				$quoteId=	$res[0]['quote_id'];							
			}		
			
			$write->query("SET FOREIGN_KEY_CHECKS=1");	
			
			if(in_array($table_sales_flat_creditmemo_comment,$resource_tables)){
				$write->query("DELETE FROM ".$table_sales_flat_creditmemo_comment." WHERE parent_id IN (SELECT entity_id FROM ".$table_sales_flat_creditmemo." WHERE order_id='".mysql_escape_string($order_id)."')");
			}
			
			if(in_array('sales_flat_creditmemo_item',$resource_tables)){
				$write->query("DELETE FROM ".$table_sales_flat_creditmemo_item." WHERE parent_id IN (SELECT entity_id FROM ".$table_sales_flat_creditmemo." WHERE order_id='".mysql_escape_string($order_id)."')");
			}
			
			if(in_array($table_sales_flat_creditmemo,$resource_tables)){
				$write->query("DELETE FROM ".$table_sales_flat_creditmemo." WHERE order_id='".mysql_escape_string($order_id)."'");
			}
			
			if(in_array($table_sales_flat_creditmemo_grid,$resource_tables)){
				$write->query("DELETE FROM ".$table_sales_flat_creditmemo_grid." WHERE order_id='".mysql_escape_string($order_id)."'");
			}
			
			if(in_array($table_sales_flat_invoice_comment,$resource_tables)){
				$write->query("DELETE FROM ".$table_sales_flat_invoice_comment." WHERE parent_id IN (SELECT entity_id FROM ".$table_sales_flat_invoice." WHERE order_id='".mysql_escape_string($order_id)."')");
			}
			
			if(in_array($table_sales_flat_invoice_item,$resource_tables)){
				$write->query("DELETE FROM ".$table_sales_flat_invoice_item." WHERE parent_id IN (SELECT entity_id FROM ".$table_sales_flat_invoice." WHERE order_id='".mysql_escape_string($order_id)."')");
			}
			
			if(in_array($table_sales_flat_invoice,$resource_tables)){
				$write->query("DELETE FROM ".$table_sales_flat_invoice." WHERE order_id='".mysql_escape_string($order_id)."'");
			}
			
			if(in_array($table_sales_flat_invoice_grid,$resource_tables)){
				$write->query("DELETE FROM ".$table_sales_flat_invoice_grid."     WHERE order_id='".mysql_escape_string($order_id)."'");
			}	
			
			if($quoteId){	
							
				if(in_array($table_sales_flat_quote_address_item,$resource_tables)){							
					$write->query("DELETE FROM ".$table_sales_flat_quote_address_item." WHERE parent_item_id  IN (SELECT address_id FROM ".$table_sales_flat_quote_address." WHERE quote_id=".$quoteId.")");
				}
				
				if(in_array($table_sales_flat_quote_shipping_rate,$resource_tables)){
					$write->query("DELETE FROM ".$table_sales_flat_quote_shipping_rate." WHERE address_id IN (SELECT address_id FROM ".$table_sales_flat_quote_address." WHERE quote_id=".$quoteId.")");
				}
				
				if(in_array($table_sales_flat_quote_item_option,$resource_tables)){
					$write->query("DELETE FROM ".$table_sales_flat_quote_item_option." WHERE item_id IN (SELECT item_id FROM ".$table_sales_flat_quote_item." WHERE quote_id=".$quoteId.")");
				}
				
				if(in_array($table_sales_flat_quote,$resource_tables)){
					$write->query("DELETE FROM ".$table_sales_flat_quote." WHERE entity_id=".$quoteId);
				}
				
				if(in_array($table_sales_flat_quote_address,$resource_tables)){
					$write->query("DELETE FROM ".$table_sales_flat_quote_address." WHERE quote_id=".$quoteId);
				}
				
				if(in_array($table_sales_flat_quote_item,$resource_tables)){
					$write->query("DELETE FROM ".$table_sales_flat_quote_item." WHERE quote_id=".$quoteId);
				}
				
				if(in_array('sales_flat_quote_payment',$resource_tables)){
					$write->query("DELETE FROM ".$table_sales_flat_quote_payment." WHERE quote_id=".$quoteId);
				}
				
			}
			
			if(in_array($table_sales_flat_shipment_comment,$resource_tables)){
				$write->query("DELETE FROM ".$table_sales_flat_shipment_comment." WHERE parent_id IN (SELECT entity_id FROM ".$table_sales_flat_shipment." WHERE order_id='".mysql_escape_string($order_id)."')");
			}
			
			if(in_array($table_sales_flat_shipment_item,$resource_tables)){
				$write->query("DELETE FROM ".$table_sales_flat_shipment_item." WHERE parent_id IN (SELECT entity_id FROM ".$table_sales_flat_shipment." WHERE order_id='".mysql_escape_string($order_id)."')");
			}
			
			if(in_array($table_sales_flat_shipment_track,$resource_tables)){						
				$write->query("DELETE FROM ".$table_sales_flat_shipment_track." WHERE order_id  IN (SELECT entity_id FROM ".$table_sales_flat_shipment." WHERE order_id='".mysql_escape_string($order_id)."')");
			}
			
			if(in_array($table_sales_flat_shipment,$resource_tables)){
				$write->query("DELETE FROM ".$table_sales_flat_shipment." WHERE order_id='".mysql_escape_string($order_id)."'");
			}
		
			if(in_array($table_sales_flat_shipment_grid,$resource_tables)){
				$write->query("DELETE FROM ".$table_sales_flat_shipment_grid." WHERE order_id='".mysql_escape_string($order_id)."'");
			}
			
			if(in_array($table_sales_flat_order,$resource_tables)){
				$write->query("DELETE FROM ".$table_sales_flat_order." WHERE entity_id='".mysql_escape_string($order_id)."'");
			}
			
			if(in_array($table_sales_flat_order_address,$resource_tables)){
				$write->query("DELETE FROM ".$table_sales_flat_order_address." WHERE parent_id='".mysql_escape_string($order_id)."'");
			}
			
			if(in_array($table_sales_flat_order_item,$resource_tables)){						
				$write->query("DELETE FROM ".$table_sales_flat_order_item." WHERE order_id='".mysql_escape_string($order_id)."'");
			}
			
			if(in_array($table_sales_flat_order_payment,$resource_tables)){
				$write->query("DELETE FROM ".$table_sales_flat_order_payment." WHERE parent_id='".mysql_escape_string($order_id)."'");
			}
			
			if(in_array($table_sales_flat_order_status_history,$resource_tables)){
				$write->query("DELETE FROM ".$table_sales_flat_order_status_history." WHERE parent_id='".mysql_escape_string($order_id)."'");
			}
			
			if($incrementId&&in_array($table_sales_flat_order_grid,$resource_tables)){						
				$write->query("DELETE FROM ".$table_sales_flat_order_grid." WHERE increment_id='".mysql_escape_string($incrementId)."'");
			}
			
			$query	=	"show tables like '%".$table_log_quote."'";
			$resource_tables_log	=	$write->fetchCol($query);	
			if($quoteId && $resource_tables_log){						
					$write->query("DELETE FROM ".$table_log_quote." WHERE quote_id=".$quoteId);							
			}
			
			$write->query("SET FOREIGN_KEY_CHECKS=1");						
				
		}      

		
		return true;
	}
	
}
