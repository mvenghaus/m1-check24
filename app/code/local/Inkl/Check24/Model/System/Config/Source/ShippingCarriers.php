<?php

class Inkl_Check24_Model_System_Config_Source_ShippingCarriers
{

	public function toOptionArray()
	{
		$methods = Mage::getSingleton('shipping/config')->getAllCarriers();

		$options = [];
		$options[] = ['value' => '', 'label' => Mage::helper('adminhtml')->__('--Please Select--')];

		foreach ($methods as $code => $method)
		{
			$title = Mage::getStoreConfig(sprintf('carriers/%s/title', $code));
			if (!$title)
			{
				$title = $method;
			}

			$options[] = ['value' => $code, 'label' => sprintf('%s (%s)', $title, $code)];
		}

		return $options;
	}

}
