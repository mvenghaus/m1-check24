<?php

class Inkl_Check24_Model_Import_Ftp
{
	private $ftpConfigHelper;
	private $generalConfigHelper;

	public function __construct()
	{
		$this->generalConfigHelper = Mage::helper('inkl_check24/config_general');
		$this->ftpConfigHelper = Mage::helper('inkl_check24/config_ftp');
	}

	public function import()
	{
		$ftpAccounts = $this->getFtpAccounts();
		foreach ($ftpAccounts as $ftpAccount)
		{
			$this->importFiles($ftpAccount);
		}
	}

	private function importFiles(array $ftpAccount)
	{
		$ftp = new Varien_Io_Ftp();

		try
		{
			$ftpAccount['passive'] = true;
			$ftpAccount['timeout'] = 20;

			if ($ftp->open($ftpAccount))
			{
				$ftp->cd('outbound');
				foreach ($ftp->ls() as $file)
				{
					if (preg_match('/-ORDER\.xml$/is', $file['text']))
					{
						$fileContent = $ftp->read($file['text']);
						if ($fileContent)
						{
							$fileContent = iconv('ISO-8859-15', 'UTF-8', $fileContent);
							$fileContent = str_replace('ISO-8859-15', 'UTF-8', $fileContent);

							Mage::getModel('inkl_check24/entity_order')
								->setFilename($file['text'])
								->setContent($fileContent)
								->save();

							$ftp->rm($file['text']);
						}
					}

					if (preg_match('/-DISPATCHNOTIFICATION\.xml$/is', $file['text']))
					{
						$ftp->rm($file['text']);
					}
				}

				$ftp->close();
			}
		} catch (Exception $e)
		{
			print_r($e->getMessage());
			exit;
		}
	}

	private function getFtpAccounts()
	{
		$ftpAccounts = [];

		foreach (Mage::app()->getStores() as $store)
		{
			if (!$this->isValidStoreFtp($store->getId()))
			{
				continue;
			}

			$ftpAccount = [
				'host' => $this->ftpConfigHelper->getHost($store->getId()),
				'user' => $this->ftpConfigHelper->getUser($store->getId()),
				'password' => $this->ftpConfigHelper->getPassword($store->getId()),
				'port' => $this->ftpConfigHelper->getPort($store->getId()),
			];

			$key = implode('#', $ftpAccount);

			if (!isset($ftpAccounts[$key]))
			{
				$ftpAccounts[$key] = $ftpAccount;
			}
		}

		return $ftpAccounts;
	}

	private function isValidStoreFtp($storeId)
	{
		return ($this->generalConfigHelper->isEnabled($storeId) &&
			$this->ftpConfigHelper->getHost($storeId) &&
			$this->ftpConfigHelper->getUser($storeId) &&
			$this->ftpConfigHelper->getPassword($storeId) &&
			$this->ftpConfigHelper->getPort($storeId));
	}

}
