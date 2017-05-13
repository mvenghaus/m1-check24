<?php

class Inkl_Check24_Model_Resource_Order extends Mage_Core_Model_Resource_Db_Abstract
{

	protected function _construct()
	{
		$this->_init('inkl_check24/orders', 'id');
	}

}
