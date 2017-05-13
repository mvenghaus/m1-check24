<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$connection = $installer->getConnection();

$tableName = 'check24_orders';

$table = $connection
	->newTable($tableName)
	->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, ['primary' => true, 'auto_increment' => true])
	->addColumn('filename', Varien_Db_Ddl_Table::TYPE_TEXT, 255)
	->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT)
	->addColumn('processed', Varien_Db_Ddl_Table::TYPE_TINYINT, 1, ['default' => 0])
	->addColumn('error', Varien_Db_Ddl_Table::TYPE_TINYINT, 1, ['default' => 0])
	->addColumn('error_message', Varien_Db_Ddl_Table::TYPE_TEXT)
	->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_DATETIME)
	->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME)
	->addIndex('processed', ['processed'])
	->addIndex('error', ['error']);

$connection->dropTable($tableName);
$connection->createTable($table);

$installer->endSetup();
