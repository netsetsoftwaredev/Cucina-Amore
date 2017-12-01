<?php
namespace WTC\Bsc\Controller\Download;

class Start extends \Magento\Framework\App\Action\Action
{
	public function __construct(\Magento\Framework\App\Action\Context $context)
    {
        parent::__construct($context);
    }
	
    public function execute()
    {
		$objectManager = $this->_objectManager;
		$urlInterface = $objectManager->get('\Magento\Framework\UrlInterface');
		$session = $this->_objectManager->create('\Magento\Customer\Model\Session');
		$resultRedirect = $this->resultRedirectFactory->create();
		if (!($session->getBusinessCustomerAuthenticated())) {
            return $resultRedirect->setPath('business-customers');
        }
		
		$this->downloadFile();
		
    }
	
	public function downloadFile(){
		ignore_user_abort(true);
		set_time_limit(0); // disable the time limit for this script
		$param = $this->getRequest()->getParams();
		$file = $param['file'];
		$path = getcwd().'/var/pdfs/'.$file;
		$fullPath = $path;
		if ($fd = fopen ($fullPath, "r")) {
			$fsize = filesize($fullPath);
			$path_parts = pathinfo($fullPath);
			$ext = strtolower($path_parts["extension"]);
			switch ($ext) {
				case "pdf":
				header("Content-type: application/pdf");
				header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download
				break;
				// add more headers for other content types here
				default;
				header("Content-type: application/octet-stream");
				header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
				break;
			}
			header("Content-length: $fsize");
			header("Cache-control: private"); //use this to open files directly
			while(!feof($fd)) {
				$buffer = fread($fd, 2048);
				echo $buffer;
			}
		}
		fclose ($fd);
		exit;

	}
}