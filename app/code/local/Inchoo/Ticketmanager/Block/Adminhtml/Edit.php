<?php

class Inchoo_Ticketmanager_Block_Adminhtml_Edit extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {

        $this->_blockGroup = 'inchoo_ticketmanager';
        $this->_controller = 'adminhtml_edit';

        $this->_headerText = Mage::helper('inchoo_ticketmanager')->__('List of Customer Tickets');

        parent::__construct();

        $this->removeButton('add');

    }
}