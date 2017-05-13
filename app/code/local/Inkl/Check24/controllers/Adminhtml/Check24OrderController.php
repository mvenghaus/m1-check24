<?php

class Inkl_Check24_Adminhtml_Check24OrderController extends Mage_Adminhtml_Controller_Action
{

	public function indexAction()
	{
		$this->loadLayout();
		$this->_addContent($this->getLayout()->createBlock('inkl_check24/adminhtml_order_gridContainer'));
		$this->renderLayout();
	}

	protected function _isAllowed()
	{
		return Mage::getSingleton('admin/session')->isAllowed('admin/system/config/inkl_check24');
	}

}
