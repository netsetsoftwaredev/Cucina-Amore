<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Controller\Adminhtml\GiftCards;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultForwardFactory;
    
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
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \MageWorx\GiftCards\Model\GiftCardsRepository $giftCardsRepository
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        $this->giftCardsRepository = $giftCardsRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $giftCardId = (int) $this->getRequest()->getParam('card_id');

        $giftCard = $this->giftCardsRepository->get($giftCardId);

        $this->giftCardsRepository->delete($giftCard);
        $this->messageManager->addSuccessMessage(__('Gift Card was deleted'));

        $resultForward = $this->resultForwardFactory->create();
        $resultForward->forward('index');
        return $resultForward;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MageWorx_GiftCards::mageworx_giftcards_giftcards');
    }
}
