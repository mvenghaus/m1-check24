<?php

class Inkl_Check24_Helper_Config_Order extends Mage_Core_Helper_Abstract
{

	const XML_PATH_SHIPPING_CARRIER = 'inkl_check24/order/shipping_carrier';
	const XML_PATH_SPLIT_STREET = 'inkl_check24/order/split_street';

	public function getShippingCarrier($storeId = null)
	{
		return Mage::getStoreConfig(self::XML_PATH_SHIPPING_CARRIER, $storeId);
	}

	public function shouldSplitStreet($storeId = null)
	{
		return Mage::getStoreConfig(self::XML_PATH_SPLIT_STREET, $storeId);
	}

}
