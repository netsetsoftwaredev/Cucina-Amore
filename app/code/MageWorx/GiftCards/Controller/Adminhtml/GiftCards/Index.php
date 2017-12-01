<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Controller\Adminhtml\GiftCards;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'MageWorx_GiftCards::mageworx_giftcards';
    
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
        $resultPage->setActiveMenu('MageWorx_GiftCards::mageworx_giftcards');
        $resultPage->addBreadcrumb(__('MageWorx Gift Cards'), __('MageWorx Gift Cards'));
        $resultPage->addBreadcrumb(__('Manage Gift Cards'), __('Manage Gift Cards'));
        $resultPage->getConfig()->getTitle()->prepend(__('MageWorx Gift Cards List'));

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MageWorx_GiftCards::mageworx_giftcards_giftcards');
    }
}
