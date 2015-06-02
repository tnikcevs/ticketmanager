<?php

class Inchoo_Ticketmanager_Adminhtml_TicketmanagerController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout()->_setActiveMenu('system/inchoo_ticketmanager/');
        $this->_addContent($this->getLayout()->createBlock('inchoo_ticketmanager/adminhtml_edit'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->getResponse()->setBody($this->getLayout()->createBlock('inchoo_ticketmanager/adminhtml_edit_grid')->toHtml());
    }
}