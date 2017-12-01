<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Controller\Adminhtml\Generate;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Edit extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'MageWorx_GiftCards::mageworx_giftcards_generate';
    
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    
    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
    
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('MageWorx_GiftCards::giftcards_generate');
        $resultPage->addBreadcrumb(__('MageWorx Gift Cards'), __('MageWorx Gift Cards'));
        $resultPage->addBreadcrumb(__('Manage Gift Cards'), __('Generate Gift Cards'));
        $resultPage->getConfig()->getTitle()->prepend(__('MageWorx Gift Cards Generate'));

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MageWorx_GiftCards::mageworx_giftcards_generate');
    }
}
