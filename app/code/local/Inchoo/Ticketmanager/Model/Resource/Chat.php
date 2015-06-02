<?php

class Inchoo_Ticketmanager_Model_Resource_Chat extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('inchoo_ticketmanager/chat', 'reply_id');
    }
}