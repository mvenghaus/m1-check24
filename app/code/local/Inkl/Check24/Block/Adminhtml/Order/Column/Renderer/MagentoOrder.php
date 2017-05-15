<?php

class Inkl_Check24_Block_Adminhtml_Order_Column_Renderer_MagentoOrder extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row)
	{
		if ($row->getMagentoOrderId())
		{
			$order = Mage::getModel('sales/order')->load($row->getMagentoOrderId());
			$adminOrderUrl = Mage::helper('adminhtml')->getUrl('adminhtml/sales_order/view', ['order_id' => $order->getId()]);

			return sprintf('<a href="%s">%s</a>', $adminOrderUrl, $order->getIncrementId());
		}

		return '-';
	}

}
