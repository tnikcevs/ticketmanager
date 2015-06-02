<?php

class Inchoo_Ticketmanager_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function  getCustomerId()
    {
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $customerData = Mage::getSingleton('customer/session')->getCustomer();
            $this->_customer_id = (int)$customerData->getId();
            return $this->_customer_id;
        } else {
            return false;
        }
    }
}