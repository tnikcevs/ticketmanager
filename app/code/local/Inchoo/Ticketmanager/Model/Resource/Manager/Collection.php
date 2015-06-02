<?php

class Inchoo_Ticketmanager_Model_Resource_Manager_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('inchoo_ticketmanager/manager');
    }

    public function getCustomerTickets()
    {
        exit('model');
        $customer_id = Mage::helper('inchoo_ticketmanager')->getCustomerId();
        $collection = Mage::getModel('inchoo_ticketmanager/manager')->getCollection();//get model collection
        $this->setCollection($collection);
//            ->addFilter('customer_id', $customer_id);//set here collection so we can call it with this->getCollection();
        var_dump('test');
        exit();
    }
}