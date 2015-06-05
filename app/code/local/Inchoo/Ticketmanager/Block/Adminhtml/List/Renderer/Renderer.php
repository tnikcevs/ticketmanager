<?php

class Inchoo_Ticketmanager_Block_Adminhtml_List_Renderer_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
        if ((int)$value === 0) {
            $value_string = Mage::helper('inchoo_ticketmanager')->__('Closed');
        } else {
            $value_string = Mage::helper('inchoo_ticketmanager')->__('Opened');
        }
        return $value_string;
    }

}
