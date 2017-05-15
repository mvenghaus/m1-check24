<?php

class Inkl_Check24_Model_Process_Order
{

	public function process()
	{
		foreach ($this->getOpenCheck24Orders() as $check24Order)
		{
			try
			{
				$openTransOrder = Mage::getModel('inkl_check24/openTrans_order')->load($check24Order->getContent());

				$this->createMagentoOrder($openTransOrder);

				$check24Order
					->setProcessed(true)
					->save();

			} catch (Exception $e)
			{
				$check24Order
					->setError(true)
					->setErrorMessage($e->getMessage())
					->save();
			}
		}
	}

	private function getOpenCheck24Orders()
	{
		$collection = Mage::getResourceModel('inkl_check24/order_collection')
			->addFieldToFilter('processed', ['eq' => 0])
			->addFieldToFilter('error', ['eq' => 0]);

		return $collection;
	}

	private function createMagentoOrder(Inkl_Check24_Model_OpenTrans_Order $openTransOrder)
	{
		/** @var Mage_Sales_Model_Quote $quote */
		$quote = Mage::getModel('sales/quote');

		$this->setBaseData($quote, $openTransOrder);
		$this->setBillingAddress($quote, $openTransOrder);
		$this->setShippingAddress($quote, $openTransOrder);
		$this->setProducts($quote, $openTransOrder);
		$this->setShippingMethod($quote, $openTransOrder);
		$this->setPaymentMethod($quote, $openTransOrder);

		$quote->collectTotals()->save();

		$service = Mage::getModel('sales/service_quote', $quote);
		$service->submitAll();
		$order = $service->getOrder();

		$order->sendNewOrderEmail();
	}

	/**
	 * @param Mage_Sales_Model_Quote $quote
	 * @param Inkl_Check24_Model_OpenTrans_Order $openTransOrder
	 */
	private function setBillingAddress(Mage_Sales_Model_Quote $quote, Inkl_Check24_Model_OpenTrans_Order $openTransOrder)
	{
		$quote->getBillingAddress()
			->setCompany($openTransOrder->getInvoiceCompany())
			->setFirstname($openTransOrder->getInvoiceFirstname())
			->setLastname($openTransOrder->getInvoiceLastname())
			->setStreet($openTransOrder->getInvoiceStreet())
			->setPostcode($openTransOrder->getInvoicePostcode())
			->setCity($openTransOrder->getInvoiceCity())
			->setCountryId($openTransOrder->getInvoiceCountryCode())
			->setRegionId($openTransOrder->getInvoiceRegionId())
			->setTelephone($openTransOrder->getInvoicePhone());
	}

	/**
	 * @param Mage_Sales_Model_Quote $quote
	 * @param Inkl_Check24_Model_OpenTrans_Order $openTransOrder
	 */
	private function setBaseData(Mage_Sales_Model_Quote $quote, Inkl_Check24_Model_OpenTrans_Order $openTransOrder)
	{
		Mage::log(sprintf('%s - setBaseData | store_id: %s', $openTransOrder->getOrderId(), $openTransOrder->getStoreId()), null, 'check24--orders.log');

		$quote
			->setStoreId($openTransOrder->getStoreId())
			->setBaseCurrencyCode($openTransOrder->getCurrencyCode())
			->setCustomerNote($openTransOrder->getOrderId())
			->setCustomerIsGuest(true)
			->setCustomerEmail($openTransOrder->getInvoiceEmail())
			->setCustomerFirstname($openTransOrder->getInvoiceFirstname())
			->setCustomerLastname($openTransOrder->getInvoiceLastname());
	}

	/**
	 * @param Mage_Sales_Model_Quote $quote
	 * @param Inkl_Check24_Model_OpenTrans_Order $openTransOrder
	 */
	private function setShippingAddress(Mage_Sales_Model_Quote $quote, Inkl_Check24_Model_OpenTrans_Order $openTransOrder)
	{
		$quote->getShippingAddress()
			->setCompany($openTransOrder->getDeliveryCompany())
			->setFirstname($openTransOrder->getDeliveryFirstname())
			->setLastname($openTransOrder->getDeliveryLastname())
			->setStreet($openTransOrder->getDeliveryStreet())
			->setPostcode($openTransOrder->getDeliveryPostcode())
			->setCity($openTransOrder->getDeliveryCity())
			->setCountryId($openTransOrder->getDeliveryCountryCode())
			->setRegionId($openTransOrder->getDeliveryRegionId())
			->setTelephone($openTransOrder->getDeliveryPhone());
	}

	/**
	 * @param Mage_Sales_Model_Quote $quote
	 * @param Inkl_Check24_Model_OpenTrans_Order $openTransOrder
	 */
	private function setProducts(Mage_Sales_Model_Quote $quote, Inkl_Check24_Model_OpenTrans_Order $openTransOrder)
	{
		foreach ($openTransOrder->getOrderItems() as $orderItem)
		{
			$quote->addProduct($orderItem['product'], $orderItem['qty']);
		}

		$quote
			->collectTotals()
			->setTotalsCollectedFlag(false);
	}

	/**
	 * @param Mage_Sales_Model_Quote $quote
	 * @param Inkl_Check24_Model_OpenTrans_Order $openTransOrder
	 */
	private function setShippingMethod(Mage_Sales_Model_Quote $quote, Inkl_Check24_Model_OpenTrans_Order $openTransOrder)
	{
		$quote->getShippingAddress()
			->setCollectShippingRates(true)
			->collectShippingRates();

		$shippingMethod = '';
		$shippingCarrier = Mage::helper('inkl_check24/config_order')->getShippingCarrier($openTransOrder->getStoreId());

		foreach ($quote->getShippingAddress()->getShippingRatesCollection() as $rate)
		{
			if ($rate->getCarrier() == $shippingCarrier)
			{
				$shippingMethod = $rate->getCode();
				break;
			}
		}

		$quote->getShippingAddress()
			->setShippingMethod($shippingMethod);
	}

	/**
	 * @param Mage_Sales_Model_Quote $quote
	 * @param Inkl_Check24_Model_OpenTrans_Order $openTransOrder
	 */
	private function setPaymentMethod(Mage_Sales_Model_Quote $quote, Inkl_Check24_Model_OpenTrans_Order $openTransOrder)
	{
		$quote->getPayment()->importData(['method' => 'check24']);
	}

}
