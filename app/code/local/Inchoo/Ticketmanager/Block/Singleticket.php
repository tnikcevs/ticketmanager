<?php

class Inchoo_Ticketmanager_Block_Singleticket extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $ticket_id = $this->getRequest()->getParam('id', false);
        $this->setTemplate('inchoo_ticketmanager/singleticket.phtml');
        $collection = Mage::getModel('inchoo_ticketmanager/chat')->getCollection()->addFilter('ticket_id', $ticket_id);
        $this->setCollection($collection);//set here collection so we can call it with this->getCollection();
    }
}