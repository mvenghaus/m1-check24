<?php

require_once '../../../../../../shell/abstract.php';

class ShellCommand extends Mage_Shell_Abstract
{

	public function run()
	{
		Mage::getSingleton('inkl_check24/import_ftp')->import();
	}

}

$shell = new ShellCommand();
$shell->run();
