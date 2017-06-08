<?php

class Inkl_Check24_Model_OpenTrans_Order
{

	private $dom;

	public function load($content)
	{
		$this->dom = new DOMDocument();
		$this->dom->loadXML($content);

		return $this;
	}

	public function getStoreId()
	{
		$partnerId = str_replace('TS-SA-', '', $this->xpathQuery('//SUPPLIER_IDREF'));

		return Mage::helper('inkl_check24/partnerId')->findStoreId($partnerId);
	}

	public function getOrderId()
	{
		return $this->xpathQuery('//ORDER_ID');
	}

	public function getCurrencyCode()
	{
		return 'EUR';
	}

	public function getInvoiceEmail()
	{
		return $this->xpathQuery("//PARTY_ROLE[text()='invoice']/following-sibling::ADDRESS//EMAIL");
	}

	public function getInvoiceCompany()
	{
		return $this->xpathQuery("//PARTY_ROLE[text()='invoice']/following-sibling::ADDRESS//NAME");
	}

	public function getInvoiceFirstname()
	{
		return $this->xpathQuery("//PARTY_ROLE[text()='invoice']/following-sibling::ADDRESS//NAME2");
	}

	public function getInvoiceLastname()
	{
		$lastname = $this->xpathQuery("//PARTY_ROLE[text()='invoice']/following-sibling::ADDRESS//NAME3");

		$lastname = str_replace(' (nur Rechnungsadresse)', '', $lastname);

		return $lastname;
	}

	public function getInvoiceStreet()
	{
		return Mage::helper('inkl_check24/street')->buildStreetData(
			$this->xpathQuery("//PARTY_ROLE[text()='invoice']/following-sibling::ADDRESS//STREET"),
			$this->xpathQuery("//PARTY_ROLE[text()='invoice']/following-sibling::ADDRESS//ADDRESS_REMARKS"),
			$this->getStoreId()
		);
	}

	public function getInvoicePostcode()
	{
		return $this->xpathQuery("//PARTY_ROLE[text()='invoice']/following-sibling::ADDRESS//ZIP");
	}

	public function getInvoiceCity()
	{
		return $this->xpathQuery("//PARTY_ROLE[text()='invoice']/following-sibling::ADDRESS//CITY");
	}

	public function getInvoiceCountryCode()
	{
		return $this->xpathQuery("//PARTY_ROLE[text()='invoice']/following-sibling::ADDRESS//COUNTRY_CODED");
	}

	public function getInvoiceRegionId()
	{
		return '';
	}

	public function getInvoicePhone()
	{
		return $this->xpathQuery("//PARTY_ROLE[text()='invoice']/following-sibling::ADDRESS//PHONE");
	}

	public function getDeliveryCompany()
	{
		return $this->xpathQuery("//PARTY_ROLE[text()='delivery']/following-sibling::ADDRESS//NAME");
	}

	public function getDeliveryFirstname()
	{
		return $this->xpathQuery("//PARTY_ROLE[text()='delivery']/following-sibling::ADDRESS//NAME2");
	}

	public function getDeliveryLastname()
	{
		return $this->xpathQuery("//PARTY_ROLE[text()='delivery']/following-sibling::ADDRESS//NAME3");
	}

	public function getDeliveryStreet()
	{
		return Mage::helper('inkl_check24/street')->buildStreetData(
			$this->xpathQuery("//PARTY_ROLE[text()='delivery']/following-sibling::ADDRESS//STREET"),
			$this->xpathQuery("//PARTY_ROLE[text()='delivery']/following-sibling::ADDRESS//ADDRESS_REMARKS"),
			$this->getStoreId()
		);
	}

	public function getDeliveryPostcode()
	{
		return $this->xpathQuery("//PARTY_ROLE[text()='delivery']/following-sibling::ADDRESS//ZIP");
	}

	public function getDeliveryCity()
	{
		return $this->xpathQuery("//PARTY_ROLE[text()='delivery']/following-sibling::ADDRESS//CITY");
	}

	public function getDeliveryCountryCode()
	{
		return $this->xpathQuery("//PARTY_ROLE[text()='delivery']/following-sibling::ADDRESS//COUNTRY_CODED");
	}

	public function getDeliveryRegionId()
	{
		return '';
	}

	public function getDeliveryPhone()
	{
		return $this->xpathQuery("//PARTY_ROLE[text()='delivery']/following-sibling::ADDRESS//PHONE");
	}

	public function getOrderItems()
	{
		$xpath = new DOMXPath($this->dom);

		$orderItems = [];
		$orderItemElements = $xpath->query('//ORDER_ITEM');

		/** @var DOMElement $domElement */
		foreach ($orderItemElements as $orderItemElement)
		{
			$sku = $this->xpathQuery('.//SUPPLIER_PID', '', $orderItemElement);
			$baseProduct = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);

			$product = Mage::getModel('catalog/product')->load($baseProduct->getId())
				->setName($this->xpathQuery('.//REMARK[@type=\'product_name\']', '', $orderItemElement))
				->setPrice($this->xpathQuery('.//PRICE_AMOUNT', '', $orderItemElement))
				->setFinalPrice($this->xpathQuery('.//PRICE_AMOUNT', '', $orderItemElement));
				->setSpecialPrice($this->xpathQuery('.//PRICE_AMOUNT', '', $orderItemElement));

			$orderItems[] = [
				'product' => $product,
				'qty' => (int)$this->xpathQuery('.//QUANTITY', '', $orderItemElement)
			];
		}

		return $orderItems;
	}

	private function xpathQuery($query, $default = '', $contextnode = null)
	{
		$xpath = new DOMXPath($this->dom);

		$nodes = $xpath->query($query, $contextnode);
		foreach ($nodes as $node)
		{
			return $node->nodeValue;
		}

		return $default;
	}

}
