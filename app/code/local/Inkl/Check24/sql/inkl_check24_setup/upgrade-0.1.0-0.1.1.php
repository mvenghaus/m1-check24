<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$connection = $installer->getConnection();

$tableName = 'check24_orders';

$connection->addColumn($tableName, 'magento_order_id', [
	'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
	'after' => 'processed',
	'comment' => 'Magento Order ID'
]);

$installer->endSetup();
