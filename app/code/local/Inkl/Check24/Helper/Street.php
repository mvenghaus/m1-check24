<?php

class Inkl_Check24_Helper_Street extends Mage_Core_Helper_Abstract
{

	public function buildStreetData($street, $remarks, $storeId)
	{
		$streetData = [];

		if (Mage::helper('inkl_check24/config_order')->shouldSplitStreet($storeId))
		{
			foreach ($this->splitStreet($street) as $part)
			{
				$streetData[] = $part;
			}
		} else
		{
			$streetData[] = $street;
		}

		if ($remarks)
		{
			$streetData[] = $remarks;
		}

		return $streetData;
	}

	public function splitStreet($street)
	{
		$street = $this->removeSpaceFromCharStreetNumber(trim($street));

		if (preg_match('/[\d]+[a-zA-Z]{0,1}$/is', $street, $results))
		{
			$streetNumber = current($results);
			$street = trim(substr($street, 0, (strlen($streetNumber) * -1)));

			return [$street, $streetNumber];
		}

		return [$street, '-'];
	}

	private function removeSpaceFromCharStreetNumber($street)
	{
		if (preg_match('/ [a-zA-Z]{1}$/is', $street, $results))
		{
			$street = substr($street, 0, -2) . trim(current($results));
		}

		return $street;
	}
}
