<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Controller\Adminhtml\GiftCards;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \MageWorx\GiftCards\Model\GiftCardsRepository
     */
    protected $giftCardsRepository;

    /**
     * @var \MageWorx\GiftCards\Model\GiftCardsFactory
     */
    protected $giftCardsFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;
 
    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        \MageWorx\GiftCards\Model\GiftCardsFactory $giftCardsFactory,
        \MageWorx\GiftCards\Model\GiftCardsRepository $giftCardsRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->registry          = $registry;
        $this->giftCardsRepository  = $giftCardsRepository;
        $this->giftCardsFactory     = $giftCardsFactory;
        parent::__construct($context);
    }

    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('MageWorx_GiftCards::giftcards_giftcards')
            ->addBreadcrumb(__('Giftcards'), __('Giftcards'))
            ->addBreadcrumb(__('Manage Giftc Cards'), __('Manage Gift Cards'));
        return $resultPage;
    }
        
    public function execute()
    {
        $giftCardId = (int) $this->getRequest()->getParam('card_id');

        if ($giftCardId) {
            $giftCard = $this->giftCardsRepository->get($giftCardId);
        } else {
            $giftCard = $this->giftCardsFactory->create();
            $giftCard->setData([]);
        }

        $data = $this->_objectManager->get('\Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $giftCard->setData($data);
        }

        $this->registry->register('mageworx_current_giftcard', $giftCard);

        $resultPage = $this->_initAction();
        
        $resultPage->addBreadcrumb(
            $giftCardId ? __('Edit Gift Card' . ' ' . $giftCard->getCardCode()) : __('New Gift Card'),
            $giftCardId ? __('Edit Gift Card' . ' ' . $giftCard->getCardCode()) : __('New Gift Card')
        );
        
        $resultPage->getConfig()->getTitle()->prepend(__('Gift Cards'));
        $resultPage->getConfig()->getTitle()
            ->prepend($giftCard->getId() ? __('Gif Card' . ' ' .$giftCard->getCardCode()) : __('New Gift Card'));

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MageWorx_GiftCards::mageworx_giftcards_giftcards');
    }
}
