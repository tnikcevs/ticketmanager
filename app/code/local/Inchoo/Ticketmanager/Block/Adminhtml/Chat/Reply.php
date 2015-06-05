<?php

class Inchoo_Ticketmanager_Block_Adminhtml_Chat_Reply extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {

        $ticket_id = $this->getRequest()->getParam('id', false);

        $form = new Varien_Data_Form(
            array(
                'id' => 'reply_form',
                'action' => $this->getUrl('*/*/save', array('id' => $ticket_id)),
                'method' => 'post',
            )
        );

        $form->setUseContainer(true);
        $this->setForm($form);

        $helper = Mage::helper('inchoo_ticketmanager');
        $fieldset = $form->addFieldset('ticket_options', array(
            'legend' => $helper->__('Ticket Options'),
            'class' => 'fieldset-wide'
        ));

        $fieldset->addField('reply', 'textarea', array(
            'name' => 'message',
            'label' => $helper->__('Reply'),
        ));
        $fieldset->addField('submit', 'submit', array(
            'name' => 'submit',
            'label' => $helper->__('Status'),
            'value'  => 'Submit',
            'tabindex' => 1
        ));

//        if (Mage::registry('inchoo_ticketmanager')) {
//            $form->setValues(Mage::registry('inchoo_ticketmanager')->getData());
//        }

        return parent::_prepareForm();
    }
}