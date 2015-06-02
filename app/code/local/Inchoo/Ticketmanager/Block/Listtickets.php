<?php

class Inchoo_Ticketmanager_Block_Listtickets extends Mage_Core_Block_Template
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('inchoo_ticketmanager/listtickets.phtml');
        $collection = Mage::getModel('inchoo_ticketmanager/manager')->getCollection();//get model collection
        $this->setCollection($collection);//set here collection so we can call it with this->getCollection();
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        $pager->setAvailableLimit(array(5=>5,10=>10,20=>20,'all'=>'all'));
        $pager->setCollection($this->getCollection());
        $this->setChild('tickets_pager', $pager);
        $this->getCollection()->load();
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('tickets_pager');
    }
}