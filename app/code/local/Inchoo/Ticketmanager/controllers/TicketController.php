<?php

class Inchoo_Ticketmanager_TicketController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function listAction()
    {

        $this->loadLayout();
        $this->renderLayout();
    }

    public function singleAction()
    {
        $ticket_id = $this->getRequest()->getParam('id', false);
        $ticket = Mage::getModel('inchoo_ticketmanager/manager')->load($ticket_id);
        if (!$ticket_id || ((int)$this->getCustomerId() !== (int)$ticket->getCustomerId())) {
            $this->norouteAction();
            return;
        }
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->renderLayout();
    }

    public function createAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }


    public function submitAction()
    {
        $message = $this->getRequest()->getParam('message', false);
        $subject = $this->getRequest()->getParam('subject', false);

        if (!$message || !$subject) {
            Mage::getSingleton('core/session')->addError('Please fill all fields!');
            $url = Mage::getUrl('inchoo_ticketmanager/ticket/create', array('_secure' => true));
            Mage::app()->getFrontController()->getResponse()->setRedirect($url)->sendResponse();
        }

        $ticket = Mage::getModel('inchoo_ticketmanager/manager');
        $ticket->setSubject($subject);
        $ticket->setMessage($message);
        $ticket->setCustomerId($this->getCustomerId());
        $ticket->setTimestamp(Mage::getSingleton('core/date')->gmtDate());
        $ticket->setWebsiteId(Mage::app()->getWebsite()->getId());
        try {
            $ticket->save();
            Mage::getSingleton('core/session')->addSuccess('Ticket submited, we\'ll get back you soon!');
            $url = Mage::getUrl('inchoo_ticketmanager/ticket/list', array('_secure' => true));
            Mage::app()->getFrontController()->getResponse()->setRedirect($url)->sendResponse();
        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError('Error processing request');
            $url = Mage::getUrl('inchoo_ticketmanager/ticket/create', array('_secure' => true));
            Mage::app()->getFrontController()->getResponse()->setRedirect($url)->sendResponse();
        }

    }

    public function replyAction()
    {
        $status = $this->getRequest()->getParam('status', false);
        $message = $this->getRequest()->getParam('message', false);
        $ticket_id = $this->getRequest()->getParam('id', false);

        $ticket = Mage::getModel('inchoo_ticketmanager/manager')->load($ticket_id);
        if ((int)$ticket->getCustomerId() !== (int)$this->getCustomerId()) {
            Mage::getSingleton('core/session')->addError('Please fill all fields!');
            $url = Mage::getUrl('inchoo_ticketmanager/ticket/single', array('id' => $ticket_id, '_secure' => true));
            Mage::app()->getFrontController()->getResponse()->setRedirect($url)->sendResponse();
        }
        if ($status === '0' || $status === '1') {
            $manager = Mage::getModel('inchoo_ticketmanager/manager')->load($ticket_id);
            $manager->setStatus((int)$status);
            try {
                $manager->save();
                Mage::getSingleton('core/session')->addSuccess('Status changed!');
            } catch (Exception $e) {
                Mage::getSingleton('core/session')->addError('Error occured!');
            }
            $url = Mage::getUrl('inchoo_ticketmanager/ticket/single', array('id' => $ticket_id, '_secure' => true));
            Mage::app()->getFrontController()->getResponse()->setRedirect($url)->sendResponse();
        } elseif ($message) {
            $chat = Mage::getModel('inchoo_ticketmanager/chat');
            $chat->setMessage($message);
            $chat->setTimestamp(Mage::getSingleton('core/date')->gmtDate());
            $chat->setUserId(null);
            $chat->setTicketId($ticket_id);
            try {
                $chat->save();
                Mage::getSingleton('core/session')->addSuccess('Reply successful!!');
            } catch (Exception $e) {
                Mage::getSingleton('core/session')->addError('Reply failed!');
            }

            $url = Mage::getUrl('inchoo_ticketmanager/ticket/single', array('id' => $ticket_id, '_secure' => true));
            Mage::app()->getFrontController()->getResponse()->setRedirect($url)->sendResponse();


        } else {
            /* redirect */
            if (!$status || !$message) {
                Mage::getSingleton('core/session')->addError('Message empty!');
                $url = Mage::getUrl('inchoo_ticketmanager/ticket/single', array('id' => $ticket_id, '_secure' => true));
                Mage::app()->getFrontController()->getResponse()->setRedirect($url)->sendResponse();
            }
        }

    }


    private function  getCustomerId()
    {
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $customerData = Mage::getSingleton('customer/session')->getCustomer();
            $this->_customer_id = (int)$customerData->getId();
            return $this->_customer_id;
        } else {
            return false;
        }
    }


    /**
     * Action predispatch
     *
     * Check customer authentication for some actions
     */
    public function preDispatch()
    {
        // a brute-force protection here would be nice
        parent::preDispatch();
        if (!$this->getRequest()->isDispatched()) {
            return;
        }

        if (!$this->_getSession()->authenticate($this)) {
            $this->setFlag('', 'no-dispatch', true);
        }

    }

    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }

}