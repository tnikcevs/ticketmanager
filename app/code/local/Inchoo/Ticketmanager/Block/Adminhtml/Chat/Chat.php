<?php

class Inchoo_Ticketmanager_Block_Adminhtml_Chat_Chat extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('inchoo_ticketmanager');
        $this->setDefaultSort('ticket_id');
//        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $ticket_id = $this->getRequest()->getParam('id', false);
        $collection = Mage::getModel('inchoo_ticketmanager/chat')
            ->getCollection()
            ->addFilter('ticket_id', $ticket_id);
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('message', array(
            'header' => Mage::helper('foggyline_logger')->__('Message'),
            'index' => 'message',
            'type' => 'text',
            'renderer' => 'Inchoo_Ticketmanager_Block_Adminhtml_Chat_Renderer_Renderer',
        ));

        return parent::_prepareColumns();
    }

}