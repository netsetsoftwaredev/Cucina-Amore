<?php
namespace WTC\Bsc\Controller\Download;
class Index extends \Magento\Framework\App\Action\Action
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
		$this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
		$this->_view->renderLayout();
    }
}