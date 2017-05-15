<?php

class Inkl_Check24_Model_Mail_Order_Error extends Inkl_Check24_Model_Mail_Abstract
{

	public function send(array $to, Inkl_Check24_Model_Entity_Order $check24Order)
	{
		return $this->sendMail($to, $this->getSubject($check24Order), $this->getBody($check24Order));
	}

	private function getSubject(Inkl_Check24_Model_Entity_Order $check24Order)
	{
		return sprintf(Mage::helper('inkl_check24')->__('Error Order Import - %s'), $check24Order->getFilename());
	}

	private function getBody(Inkl_Check24_Model_Entity_Order $check24Order)
	{
		return $check24Order->getErrorMessage();
	}

}
