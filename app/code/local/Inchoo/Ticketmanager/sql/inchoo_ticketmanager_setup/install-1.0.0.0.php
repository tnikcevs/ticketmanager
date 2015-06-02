<?php

$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('inchoo_ticketmanager/manager'))
    ->addColumn('ticket_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true
    ), 'Ticket Id')
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
        'nullable' => false,
    ), 'Customer Id')
    ->addColumn('website_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 2, array(
        'nullable' => false,
    ), 'Website Id')
    ->addColumn('timestamp', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => false
    ), 'Timestamp')
    ->addColumn('subject', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false
    ), 'Subject')
    ->addColumn('message', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false
    ), 'Message')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_TINYINT, 1, array(
        'nullable' => false,
        'default' => 1
    ), 'Status')
    ->addForeignKey(
        $installer->getFkName('inchoo_ticketmanager/manager', 'customer_id', 'customer/entity', 'entity_id'),
        'customer_id',
        $installer->getTable('customer/entity'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )->addForeignKey(
        $installer->getFkName('inchoo_ticketmanager/manager', 'website_id', 'core/website', 'website_id'),
        'website_id',
        $installer->getTable('core/website'),
        'website_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    );

$installer->getConnection()->createTable($table);

$table = $installer->getConnection()
    ->newTable($installer->getTable('inchoo_ticketmanager/chat'))
    ->addColumn('reply_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 15, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true
    ), 'Reply Id')
    ->addColumn('ticket_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
        'nullable' => false,
    ), 'Ticket Id')
    ->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
        'nullable' => false,
    ), 'User Id')
    ->addColumn('timestamp', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => false
    ), 'Timestamp')
    ->addColumn('message', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false
    ), 'Message')
    ->addForeignKey(
        $installer->getFkName('inchoo_ticketmanager/chat', 'ticket_id', 'inchoo_ticketmanager/manager', 'ticket_id'),
        'ticket_id',
        $installer->getTable('inchoo_ticketmanager/manager'),
        'ticket_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )->addForeignKey(
        $installer->getFkName('inchoo_ticketmanager/chat', 'user_id', 'customer/entity', 'entity_id'),
        'user_id',
        $installer->getTable('customer/entity'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    );

$installer->getConnection()->createTable($table);

$installer->endSetup();