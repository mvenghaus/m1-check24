<?php

class Inkl_Check24_Block_Adminhtml_Order_GridContainer extends Mage_Adminhtml_Block_Widget_Grid_Container
{

	public function __construct()
	{
		$this->_controller = 'adminhtml_order_gridContainer';
		$this->_blockGroup = 'inkl_check24';
		$this->_headerText = Mage::helper('inkl_check24')->__('Check 24 Orders');

        parent::__construct();

        $this->_removeButton('add');
    }

}
