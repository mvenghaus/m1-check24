<?php

class Inkl_Check24_Helper_Config_General extends Mage_Core_Helper_Abstract
{

	const XML_PATH_ENABLED = 'inkl_check24/general/enabled';
	const XML_PATH_PARTNER_ID = 'inkl_check24/general/partner_id';

	public function isEnabled($storeId = null)
	{
		return Mage::getStoreConfigFlag(self::XML_PATH_ENABLED, $storeId);
	}

	public function getPartnerId($storeId = null)
	{
		return Mage::getStoreConfig(self::XML_PATH_PARTNER_ID, $storeId);
	}

}
