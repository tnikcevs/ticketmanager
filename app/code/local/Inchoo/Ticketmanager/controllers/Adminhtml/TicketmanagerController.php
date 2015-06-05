<?php

class Inchoo_Ticketmanager_Adminhtml_TicketmanagerController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout()->_setActiveMenu('system/inchoo_ticketmanager/');
        $this->_addContent($this->getLayout()->createBlock('inchoo_ticketmanager/adminhtml_list'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->getResponse()->setBody($this->getLayout()->createBlock('inchoo_ticketmanager/adminhtml_list_grid')->toHtml());
    }

    public function viewAction()
    {
        $this->loadLayout()->_setActiveMenu('system/inchoo_ticketmanager/');
        $this->_addContent($this->getLayout()->createBlock('inchoo_ticketmanager/adminhtml_chat'));
        $this->_addContent($this->getLayout()->createBlock('inchoo_ticketmanager/adminhtml_chat_mainmessage'));
        $this->_addContent($this->getLayout()->createBlock('inchoo_ticketmanager/adminhtml_chat_chat'));
        $this->_addContent($this->getLayout()->createBlock('inchoo_ticketmanager/adminhtml_chat_reply'));
        $this->renderLayout();
    }

    public function saveAction()
    {

        $ticket_id = $this->getRequest()->getParam('id', false);
        $message = $this->getRequest()->getParam('message', false);

        if (!$ticket_id || !$message) {
            Mage::getSingleton('core/session')->addError('Write something!');
            $url = Mage::getUrl('adminhtml/ticketmanager/view', array('id' => $ticket_id, '_secure' => true));
            Mage::app()->getFrontController()->getResponse()->setRedirect($url)->sendResponse();
        }

        $ticket = Mage::getModel('inchoo_ticketmanager/chat');
        $ticket->setTicketId($ticket_id);
        $ticket->setMessage($message);
        $userId = Mage::getSingleton('admin/session')->getUser()->getUserId();
        $ticket->setUserId($userId);
        //$ticket->setTimestamp(Mage::getSingleton('core/date')->gmtDate());
        try {
            $ticket->save();
            Mage::getSingleton('core/session')->addSuccess('Message submited');
        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
        }

        Mage::app()->getFrontController()->getResponse()->setRedirect($this->getUrl('*/*/view', array('id' => $ticket_id)))->sendResponse();
    }

    public function closeAction()
    {
        $ticket_id = $this->getRequest()->getParam('id', false);
        $ticket = Mage::getModel('inchoo_ticketmanager/manager')->load($ticket_id);
        $ticket->setStatus(0);
        try {
            $ticket->save();
            Mage::getSingleton('core/session')->addSuccess('Ticket Closed');
        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError('Ticket failed to close');
        }
        Mage::app()->getFrontController()->getResponse()->setRedirect($this->getUrl('*/*/view', array('id' => $ticket_id)))->sendResponse();
    }
}