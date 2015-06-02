<?php

class Inchoo_Ticketmanager_Model_Chat extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        $this->_init('inchoo_ticketmanager/chat');
    }


    public function getChats()
    {
        return $this->getCollection()->addTicketFilter($this->getId());
    }
}