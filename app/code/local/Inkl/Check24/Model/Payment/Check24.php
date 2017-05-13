<?php

class Inkl_Check24_Model_Payment_Check24 extends Mage_Payment_Model_Method_Abstract
{

	protected $_code = 'check24';

	protected $_isInitializeNeeded = true;
	protected $_canUseInternal = false;
	protected $_canUseForMultishipping = false;
	protected $_canUseCheckout = false;

}
