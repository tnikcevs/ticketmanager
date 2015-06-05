<?php

class Inchoo_Ticketmanager_Block_Adminhtml_Chat extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'inchoo_ticketmanager';
        $this->_controller = 'adminhtml_chat';

        $ticket_id = $this->getRequest()->getParam('id', false);
        $this->_addButton('close_ticket', array(
            'label' => $this->__('Close Ticket'),
            'onclick' => "setLocation('{$this->getUrl('*/*/close', array('id' => $ticket_id))}')",
        ));
        parent::__construct();
        $this->removeButton('add');
    }

}