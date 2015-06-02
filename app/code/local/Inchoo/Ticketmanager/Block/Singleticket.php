<?php

class Inchoo_Ticketmanager_Block_Singleticket extends Mage_Core_Block_Template
{

    public function __construct()
    {
        $post = $this->getRequest()->getParams();
        $ticket_id = reset($post);
        parent::__construct();
        $this->setTemplate('inchoo_ticketmanager/singleticket.phtml');
        $collection = Mage::getModel('inchoo_ticketmanager/chat')
            ->getCollection()->addFilter('ticket_id', $ticket_id);//get model collection
        $this->setCollection($collection);//set here collection so we can call it with this->getCollection();
    }
}