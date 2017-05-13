<?php

class Inkl_Check24_Block_Adminhtml_Order_Column_Renderer_Error extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row)
	{
		if ($row->getError())
		{
			return $row->getErrorMessage();
		}

		return '-';
	}

}
