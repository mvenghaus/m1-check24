<?php

class Inkl_Check24_Model_Cron_Order
{

	public function run()
	{
		Mage::getSingleton('inkl_check24/import_ftp')->import();
		Mage::getSingleton('inkl_check24/process_order')->process();
	}

}
