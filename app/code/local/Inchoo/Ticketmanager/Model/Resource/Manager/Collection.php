<?php

class Inchoo_Ticketmanager_Model_Resource_Manager_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('inchoo_ticketmanager/manager');
    }
}