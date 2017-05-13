<?php

class Inkl_Check24_Helper_PartnerId extends Mage_Core_Helper_Abstract
{

	public function findStoreId($partnerId)
	{
		foreach (Mage::app()->getStores() as $store)
		{
			if (Mage::helper('inkl_check24/config_general')->getPartnerId($store->getId()) == $partnerId)
			{
				return $store->getId();
			}
		}

		return null;
	}

}
