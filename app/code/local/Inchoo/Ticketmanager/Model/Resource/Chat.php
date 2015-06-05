<?php

class Inchoo_Ticketmanager_Model_Resource_Chat extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('inchoo_ticketmanager/chat', 'reply_id');
    }

//    protected function _beforeSave(Mage_Core_Model_Abstract $object)
//    {
//
//        //if($object->isObjectNew()) {}
//
//        if(!$object->getId()) {
//            $object->setTimestamp(Mage::getSingleton('core/date')->gmtDate());
//        }
//
//        return $this;
//
//        return parent::_beforeSave($object);
//    }
}