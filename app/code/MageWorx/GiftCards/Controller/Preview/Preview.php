<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Controller\Preview;

use \Magento\Framework\App\Action\Action;

class Preview extends Action
{
    /** @var  \Magento\Framework\Controller\Result\RawFactory */
    protected $rawResultFactory;
    
    /**
     * Gift Cards Factory
     *
     * @var \MageWorx\GiftCards\Model\GiftCardsFactory
     */
    protected $giftCardsFactory;
     
    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\RawFactory $rawResultFactory,
     * @param \MageWorx\GiftCards\Model\GiftCardsRepository $giftCardsRepository;
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\RawFactory $rawResultFactory,
        \MageWorx\GiftCards\Model\GiftCardsFactory $giftCardsFactory
    ) {
    
        $this->rawResultFactory = $rawResultFactory;
        $this->giftCardsFactory = $giftCardsFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $card = $this->giftCardsFactory->create();
        $result = $this->rawResultFactory->create();
        $result->setContents($card->preview($data));
        return $result;
    }
}
