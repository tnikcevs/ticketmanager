<?php

class Inchoo_Ticketmanager_Block_Index extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('inchoo_ticketmanager/index.phtml');
    }

}