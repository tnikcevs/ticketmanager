<?php

class Inchoo_Ticketmanager_Block_Adminhtml_Chat_Button extends Mage_Adminhtml_Block_Widget_Container
{
    public function __construct()
    {
        $this->_addButton('module_controller', array(
            'label' => $this->__('Something Action'),
            'onclick' => "setLocation('{$this->getUrl('*/module/anyaction')}')",
        ));
        parent::_construct();
    }
}