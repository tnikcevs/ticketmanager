<?php

class Inchoo_Ticketmanager_Model_Resource_Manager extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('inchoo_ticketmanager/manager', 'ticket_id');
    }

}