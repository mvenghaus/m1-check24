<?php

class Inkl_Check24_Block_Adminhtml_Order_GridContainer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

	public function __construct()
	{
		parent::__construct();
		$this->setId('adminhtml_order_gridContainer_grid');
		$this->setDefaultSort('id');
		$this->setDefaultDir('DESC');
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getResourceModel('inkl_check24/order_collection')
			->addFieldToSelect('*');

		$this->setCollection($collection);

		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{

		$this->addColumn('id', [
			'header' => Mage::helper('inkl_check24')->__('ID'),
			'width' => '75px',
			'index' => 'id',
		]);

		$this->addColumn('filename', [
			'header' => Mage::helper('inkl_check24')->__('Filename'),
			'index' => 'filename',
		]);

		$this->addColumn('processed', [
			'header' => Mage::helper('inkl_check24')->__('Processed'),
			'width' => '150px',
			'index' => 'processed',
			'type' => 'options',
			'options' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray()
		]);

		$this->addColumn('magento_order_id', [
			'header' => Mage::helper('inkl_check24')->__('Magento Order'),
			'width' => '150px',
			'index' => 'magento_order_id',
			'renderer' => 'inkl_check24/adminhtml_order_column_renderer_magentoOrder'
		]);

		$this->addColumn('error', [
			'header' => Mage::helper('inkl_check24')->__('Error'),
			'width' => '150px',
			'index' => 'error',
			'renderer' => 'inkl_check24/adminhtml_order_column_renderer_error'
		]);

		$this->addColumn('updated_at', [
			'header' => Mage::helper('inkl_check24')->__('Updated At'),
			'width' => '150px',
			'index' => 'updated_at',
			'type' => 'datetime'
		]);

		$this->addColumn('created_at', [
			'header' => Mage::helper('inkl_check24')->__('Created At'),
			'width' => '150px',
			'index' => 'created_at',
			'type' => 'datetime'
		]);

		return parent::_prepareColumns();
	}

	public function getRowUrl($row)
	{
		return '#';
	}

}
