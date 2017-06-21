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
		return Mage::getSingleton('admin/session')->isAllowed('admin/sales/inkl_check24');
	}


	public function massRetryAction()
	{
		$ids = $this->getRequest()->getPost('ids');
		foreach ($ids as $id)
		{
			Mage::getModel('inkl_check24/entity_order')->load($id)
				->setProcessed(0)
				->setMagentoOrderId('')
				->setError(0)
				->setErrorMessage('')
				->save();

			Mage::getSingleton('adminhtml/session')->addSuccess(sprintf(Mage::helper('inkl_check24')->__('#%d was successfully resettet.'), $id));

		}

		$this->_redirect('*/*/index');
	}

}
