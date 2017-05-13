<?php

class Inkl_Check24_Model_Resource_Order_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

	protected function _construct()
	{
		$this->_init('inkl_check24/entity_order', 'inkl_check24/order');
	}

}
