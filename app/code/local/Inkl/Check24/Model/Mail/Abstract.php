<?php

class Inkl_Check24_Model_Mail_Abstract
{

	protected function sendMail(array $to, $subject, $body)
	{
		$emailTemplate = Mage::getModel('core/email_template')
			->setSenderName(Mage::getStoreConfig('trans_email/ident_general/name'))
			->setSenderEmail(Mage::getStoreConfig('trans_email/ident_general/email'))
			->setTemplateSubject($subject)
			->setTemplateText($body);

		return $emailTemplate->send($to);
	}

}
