<?php

namespace WTC\Bsc\Controller\Enquiry;

class Index extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
		$objectManager = $this->_objectManager;
		$customerSession = $objectManager->get('Magento\Customer\Model\Session');
		$urlInterface = $objectManager->get('\Magento\Framework\UrlInterface');
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}