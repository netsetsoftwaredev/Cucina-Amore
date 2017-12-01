<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Controller\Adminhtml\Generate;

use Magento\Backend\App\Action\Context;

class Save extends \Magento\Backend\App\Action
{

   /**
    * @var \MageWorx\GiftCards\Model\GiftCardsRepository
    */
    protected $giftCardsRepository;

   /**
    * @var \MageWorx\GiftCards\Model\GiftCardsFactory
    */
    protected $giftCardsFactory;

    public function __construct(
        Context $context,
        \MageWorx\GiftCards\Model\GiftCardsRepository $giftCardsRepository,
        \MageWorx\GiftCards\Model\GiftCardsFactory $giftCardsFactory
    ) {
    
        $this->giftCardsRepository = $giftCardsRepository;
        $this->giftCardsFactory = $giftCardsFactory;
        parent::__construct($context);
    }
   
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
       
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            $model  = $this->giftCardsFactory->create();
            $count  = $this->getRequest()->getParam('giftcards_count');
            $amount = $this->getRequest()->getParam('giftcards_amount');
            $status = $this->getRequest()->getParam('giftcards_status', \MageWorx\GiftCards\Model\GiftCards::STATUS_ACTIVE);
            $type   = $this->getRequest()->getParam('giftcards_type', \MageWorx\GiftCards\Model\GiftCards::TYPE_EMAIL);
           
            try {
                for ($i = 0; $i < $count; $i++) {
                    $model->setData([]);
                    $model->setCardAmount($amount);
                    $model->setCardType($type);
                    $model->setCardStatus($status);
                    $this->giftCardsRepository->save($model);
                }
               
                $this->messageManager->addSuccessMessage(__($count.' Gift Cards was successfully generated'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                return $resultRedirect->setPath('*/giftcards/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                   $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                   $this->messageManager->addError($e->getMessage());
                   $this->messageManager->addException($e, __('Something went wrong while generate the Gift Card.'));
            }

             return $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MageWorx_GiftCards::mageworx_giftcards_generate');
    }
}
