<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Controller\Adminhtml\GiftCards;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Magento\Sales\Api\OrderRepositoryInterface;

class Resend extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var MageWorx\GiftCards\Model\GiftCardsRepository
     */
    protected $giftCardsRepository;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;
    
    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        OrderRepositoryInterface $orderRepository,
        \MageWorx\GiftCards\Model\GiftCardsRepository $giftCardsRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->registry          = $registry;
        $this->giftCardsRepository  = $giftCardsRepository;
        $this->orderRepository   = $orderRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $giftCardId = (int) $this->getRequest()->getParam('card_id');

        $giftCard = $this->giftCardsRepository->get($giftCardId);

        $resultRedirect = $this->resultRedirectFactory->create();
        
        if ($giftCard->getMailToEmail()) {
            try {
                if ($giftCard->getOrderId()) {
                    $order = $this->orderRepository->get($giftCard->getOrderId());
                    $giftCard->send($order);
                } else {
                    $giftCard->sendNoOrder();
                }
                    $this->messageManager->addSuccessMessage(__('Gift Card email were successfully resend'));
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->messageManager->addException($e, __('Something went wrong while sending the Gift Card.'));
            }
        } else {
                $this->messageManager->addError(__('Unable to send Gift Card. Try to fill "To Email" field.'));
        }
        
        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MageWorx_GiftCards::mageworx_giftcards_giftcards');
    }
}
