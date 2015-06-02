<?php

class Inchoo_Ticketmanager_Block_Adminhtml_Edit_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('inchoo_ticketmanager');
        $this->setDefaultSort('ticket_id');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('inchoo_ticketmanager/manager')->getCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('ticket_id', array(
            'header' => Mage::helper('foggyline_logger')->__('Ticket Id '),
            'index' => 'ticket_id',
            'type' => 'text',
            'width' => '170px',
        ));
        $this->addColumn('timestamp', array(
            'header' => Mage::helper('foggyline_logger')->__('Timestamp'),
            'index' => 'timestamp',
            'type' => 'text',
            'width' => '170px',
        ));
        $this->addColumn('subject', array(
            'header' => Mage::helper('foggyline_logger')->__('Subject'),
            'index' => 'subject',
            'type' => 'text',
        ));
        $this->addColumn('status', array(
            'header' => Mage::helper('foggyline_logger')->__('Status'),
            'index' => 'status',
            'type' => 'text',
            'width' => '170px',
        ));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}