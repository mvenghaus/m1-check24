<?php

require_once '../../../../../../shell/abstract.php';

class ShellCommand extends Mage_Shell_Abstract
{

	public function run()
	{
		Mage::getSingleton('inkl_check24/cron_order')->run();
	}

}

$shell = new ShellCommand();
$shell->run();
