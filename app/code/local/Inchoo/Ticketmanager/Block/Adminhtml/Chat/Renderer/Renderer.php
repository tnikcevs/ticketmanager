<?php

class Inchoo_Ticketmanager_Block_Adminhtml_Chat_Renderer_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $user_id = $row->getData()['user_id'];
        $ticket_id = $row->getData()['ticket_id'];

        if ($user_id === null) {
            $customer = Mage::getModel('inchoo_ticketmanager/manager')->load($ticket_id)->getCustomerId();
            $customer = Mage::getModel('customer/customer')->load($customer);
            $name = $customer->getFirstname() . ' ' . $customer->getLastname();
            $name = $this->escapeHtml($name);
            $color = '#6ca7ff';
        } else {
            $admin = Mage::getModel('admin/user')->load($user_id)->getUsername();
            $name = $this->escapeHtml($admin);
            $color = '#ff2728';
        }

        $value = $row->getData($this->getColumn()->getIndex());
        $value = $this->escapeHtml($value);
        return "<span style='color:$color;'>" . $name . '</span>' . ' : ' . $value;
    }

}
