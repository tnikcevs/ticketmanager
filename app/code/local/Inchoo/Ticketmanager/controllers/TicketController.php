<?php

class Inchoo_Ticketmanager_TicketController extends Mage_Core_Controller_Front_Action
{

    private $status = false;
    private $_subject = false;
    private $_message = false;
    private $_customer_id = false;
    private $_error = '';

//    public function _construct()
//    {
//        parent::_construct();
//        $this->getCustomerId();
//    }

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
        $post = $this->getRequest()->getParams();
        $ticket = Mage::getModel('inchoo_ticketmanager/manager');

        if ((current(array_keys($post)) !== $this->getCustomerId()) || $ticket->load($post[current(array_keys($post))])->getId() === null) {
            $url = Mage::getUrl('inchoo_ticketmanager/ticket/list', array('_secure' => true));
            Mage::app()->getFrontController()->getResponse()->setRedirect($url)->sendResponse();
        }
        $this->loadLayout();
        $this->renderLayout();
    }

    public function createAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }


    public function submitAction()
    {
        $post = $this->getRequest()->getPost();

        /* if not submit, redirect */
        if (!isset($post['message']) || !isset($post['subject'])) {
            $url = Mage::getUrl('inchoo_ticketmanager/ticket/create', array('_secure' => true));
            Mage::app()->getFrontController()->getResponse()->setRedirect($url)->sendResponse();
        }

        $this->_message = $post['message'];
        $this->_subject = $post['subject'];

        if ($this->checkBeforeSubmit()) {
            $ticket = Mage::getModel('inchoo_ticketmanager/manager');
            $ticket->setSubject($this->_subject);
            $ticket->setMessage($this->_message);
            $ticket->setCustomerId($this->_customer_id);
            $ticket->setTimestamp(Mage::getSingleton('core/date')->gmtDate());
            $ticket->setWebsiteId(Mage::app()->getWebsite()->getId());
            try {
                $ticket->save();
                $this->status = true;
                $response_message = 'Ticket submited, we\'ll get back you soon!';
            } catch (Exception $e) {
                $this->status = false;
                $response_message = $e->getMessage() . " ";
            }
        } else {
            $response_message = $this->_error;
        }
        $response = array('message' => $response_message, 'status' => $this->status);

        $url = Mage::getUrl('inchoo_ticketmanager/ticket/list', array('_secure' => true));
        Mage::app()->getFrontController()->getResponse()->setRedirect($url)->sendResponse();
//        echo json_encode($response);
    }

    public function replyAction()
    {
        $response_message = 'default';
        $post = $this->getRequest()->getParams();
        if (isset($post['status'])) {
            $manager = Mage::getModel('inchoo_ticketmanager/manager')->load((int)reset($post));
            $manager->setStatus(0);
            try {
                $manager->save();
            } catch (Exception $e) {
                $this->status = false;
                $response_message = $e->getMessage() . " ";
                exit($e->getMessage());
            }
            /*redirect via submit*/
            $url = Mage::getUrl('inchoo_ticketmanager/ticket/list', array('_secure' => true));
            Mage::app()->getFrontController()->getResponse()->setRedirect($url)->sendResponse();
        } elseif (isset($post['message']) && !empty($post['message'])) {
            $chat = Mage::getModel('inchoo_ticketmanager/chat');
            $chat->setMessage($post['message']);
            unset($post['message']);
            $ticket_id = (int)reset($post);

            $chat->setTimestamp(Mage::getSingleton('core/date')->gmtDate());

            if ($this->getCustomerId() && is_int($ticket_id)) {
                $chat->setUserId($this->getCustomerId());
                $chat->setTicketId($ticket_id);

                try {
                    $chat->save();
                    $this->status = true;
                    $response_message = 'Reply success!';
                } catch (Exception $e) {
                    $this->status = false;
                    $response_message = $e->getMessage() . " ";
                }
            }

            /*redirect via submit*/
            $url = Mage::getUrl('inchoo_ticketmanager/ticket/single', array($this->getCustomerId() => $ticket_id, '_secure' => true));
            Mage::app()->getFrontController()->getResponse()->setRedirect($url)->sendResponse();

            /*json*/
//            $response = array('message' => $response_message, 'status' => $this->status);
//            echo json_encode($response);


        } else {
            /* redirect */
            if (!isset($post['message']) || !isset($post['subject'])) {
                $url = Mage::getUrl('inchoo_ticketmanager/ticket/index', array('_secure' => true));
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

    private function checkBeforeSubmit()
    {
        if (!$this->getCustomerId()) {
            $this->_error .= 'Customer not registered! ';
        }

        if (!$this->_subject || empty($this->_subject)) {
            $this->_error .= 'Subject empty! ';
        }

        if (!$this->_message || empty($this->_message)) {
            $this->_error .= 'Message empty! ';
        }

        if (!$this->getCustomerId() || (!$this->_subject || empty($this->_subject)) || (!$this->_message || empty($this->_message))) {
            return false;
        }

        return true;
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

        $action = $this->getRequest()->getActionName();
        $openActions = array(
            'create',
            'login',
            'logoutsuccess',
            'forgotpassword',
            'forgotpasswordpost',
            'resetpassword',
            'resetpasswordpost',
            'confirm',
            'confirmation'
        );
        $pattern = '/^(' . implode('|', $openActions) . ')/i';

        if (!preg_match($pattern, $action)) {
            if (!$this->_getSession()->authenticate($this)) {
                $this->setFlag('', 'no-dispatch', true);
            }
        } else {
            $this->_getSession()->setNoReferer(true);
        }
    }

    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }

}