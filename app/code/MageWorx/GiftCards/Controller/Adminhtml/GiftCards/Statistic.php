<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Controller\Adminhtml\GiftCards;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;

class Statistic extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;
    protected $registry;

    /**
     * @var \MageWorx\GiftCards\Model\GiftCardsRepository
     */
    protected $giftCardsRepository;
    
    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        \MageWorx\GiftCards\Model\GiftCardsRepository $giftCardsRepository
    ) {
    
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->giftCardsRepository  = $giftCardsRepository;
        $this->registry = $registry;
    }

    public function execute()
    {
        $giftCardId = (int) $this->getRequest()->getParam('card_id');

        $giftCard = $this->giftCardsRepository->get($giftCardId);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('MageWorx_GiftCards::giftcards');
        $resultPage->addBreadcrumb(__('MageWorx Gift Cards'), __('MageWorx Gift Cards'));
        $resultPage->addBreadcrumb(__('Gift Card Statistic'), __('Gift Card Statistic'));
        $resultPage->getConfig()->getTitle()->prepend(__('Gift Card Statistic'));

        $this->registry->register('mageworx_current_giftcard', $giftCard);

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MageWorx_GiftCards::mageworx_giftcards_giftcards');
    }
}
