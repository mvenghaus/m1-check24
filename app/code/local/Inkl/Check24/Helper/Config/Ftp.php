<?php

class Inkl_Check24_Helper_Config_Ftp extends Mage_Core_Helper_Abstract
{

	const XML_PATH_HOST = 'inkl_check24/ftp/host';
	const XML_PATH_USER = 'inkl_check24/ftp/user';
	const XML_PATH_PASSWORD = 'inkl_check24/ftp/password';
	const XML_PATH_PORT = 'inkl_check24/ftp/port';

	public function getHost($storeId = null)
	{
		return Mage::getStoreConfig(self::XML_PATH_HOST, $storeId);
	}

	public function getUser($storeId = null)
	{
		return Mage::getStoreConfig(self::XML_PATH_USER, $storeId);
	}

	public function getPassword($storeId = null)
	{
		return Mage::getStoreConfig(self::XML_PATH_PASSWORD, $storeId);
	}

	public function getPort($storeId = null)
	{
		return Mage::getStoreConfig(self::XML_PATH_PORT, $storeId);
	}

}
