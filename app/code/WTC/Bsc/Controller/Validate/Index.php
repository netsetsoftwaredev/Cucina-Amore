<?php

namespace WTC\Bsc\Controller\Validate;

class Index extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
		$data = $this->getRequest()->getPostValue();
		$session = $this->_objectManager->create('\Magento\Customer\Model\Session');
		$collection = $this->_objectManager->create('WTC\Bsc\Model\ResourceModel\Bsc\Collection')->addFieldToFilter('password', $data['password']);
		$resultRedirect = $this->resultRedirectFactory->create();
		if(count($collection) > 0){
			$session->setBusinessCustomerAuthenticated(true);
			return $resultRedirect->setPath('*/download');
		}else{
			$this->messageManager->addSuccess(
				__('Invalid password, Please try with correct provided password')
			);
			return $resultRedirect->setPath('*/');
		}
    }
}