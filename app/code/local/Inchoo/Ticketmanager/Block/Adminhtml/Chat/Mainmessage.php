<?php

class Inchoo_Ticketmanager_Block_Adminhtml_Chat_Mainmessage extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {

        $ticket_id = $this->getRequest()->getParam('id', false);

        $onclick = "Fieldset.toggleCollapse(454, http://fwefe.com);";

        $form = new Varien_Data_Form(
            array(
                'id' => 'message_show',
                'action' => $this->getUrl('*/*/save', array('id' => $ticket_id)),
                'method' => 'post',
                'expanded' => true,
                'onclick' => $onclick
            )
        );

        $form->setUseContainer(true);
        $this->setForm($form);

        $helper = Mage::helper('inchoo_ticketmanager');
        $fieldset = $form->addFieldset('main_ticket_message', array(
            'legend' => $helper->__('Main Ticket Message'),
            'class' => 'config collapseable',
            'expanded' => false
        ));


        $ticket = Mage::getModel('inchoo_ticketmanager/manager')->load($ticket_id);
        $customer = $ticket->getCustomerId();
        $customer = Mage::getModel('customer/customer')->load($customer);

        $fieldset->addField('from', 'note', array(
            'text' => $this->escapeHtml($customer->getEmail()),
        ));

        $fieldset->addField('note', 'note', array(
            'text' => $this->escapeHtml($ticket->getMessage()),
        ));

        return parent::_prepareForm();
    }

    protected function _getHeaderTitleHtml($element)
    {
        return '<div class="entry-edit-head collapseable" ><a id="' . $element->getHtmlId()
        . '-head" href="#" onclick="Fieldset.toggleCollapse(\'' . $element->getHtmlId() . '\', \''
        . $this->getUrl('*/*/state') . '\'); return false;">' . $element->getLegend() . '</a></div>';
    }
}