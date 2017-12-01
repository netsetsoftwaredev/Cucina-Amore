<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftСards\Controller\Adminhtml\GiftСards;

class PrintCard extends \Magento\Backend\App\Action
{
    /** @var  \Magento\Framework\View\Result\Page */
    protected $resultPageFactory;

    /** @var  \MageWorx\GiftCards\Model\GiftCardsRepository */
    protected $giftCardsRepository;
    
    protected $registry;
    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \MageWorx\GiftCards\Model\GiftCardsRepository $giftCardsRepository,
        \Magento\Framework\Registry $registry
    ) {
    
        $this->resultPageFactory = $resultPageFactory;
        $this->registry = $registry;
        $this->giftCardsRepository = $giftCardsRepository;
        parent::__construct($context);
    }

    /**
     * Blog Index, shows a list of recent blog posts.
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $giftCardId = (int) $this->getRequest()->getParam('card_id');

        $giftCard = $this->giftCardsRepository->get($giftCardId);

        $this->registry->register('mageworx_print_giftcard', $giftCard);
        
        return $this->resultPageFactory->create();
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MageWorx_GiftCards::mageworx_giftcards_giftcards');
    }
}
