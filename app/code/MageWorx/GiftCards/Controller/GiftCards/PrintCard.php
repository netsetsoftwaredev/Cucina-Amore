<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Controller\GiftCards;

use \Magento\Framework\App\Action\Action;

class PrintCard extends Action
{
    /** @var  \Magento\Framework\View\Result\Page */
    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \MageWorx\GiftCards\Model\GiftCardsRepository
     */
    protected $giftCardsRepository;

    /**
     * PrintCard constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     * @param \MageWorx\GiftCards\Model\GiftCardsRepository $giftCardsRepository
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \MageWorx\GiftCards\Model\GiftCardsRepository $giftCardsRepository
    ) {
    
        $this->resultPageFactory = $resultPageFactory;
        $this->registry = $registry;
        $this->giftCardsRepository = $giftCardsRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $giftCardCode = $this->getRequest()->getParam('code');

        try {
            $giftCard = $this->giftCardsRepository->getByCode($giftCardCode);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return $this->resultPageFactory->create();
        }

        $this->registry->register('mageworx_print_giftcard', $giftCard);
        return $this->resultPageFactory->create();
    }
}
