<?php

class Inchoo_Ticketmanager_Block_Createticket extends Mage_Core_Block_Template
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('inchoo_ticketmanager/createticket.phtml');
    }

    public function test()
    {
        return "hohoho";
    }
}