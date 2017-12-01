<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Controller\Adminhtml\GiftCards;

use Magento\Backend\App\Action\Context;

class Save extends \Magento\Backend\App\Action
{

    protected $formKeyValidator;
   
   /**
    * @var \MageWorx\GiftCards\Model\GiftCardsFactory
    */
    protected $giftCardsFactory;
   
   /**
    * @var \MageWorx\GiftCards\Model\GiftCardsRepository
    */
    protected $giftCardsRepository;
   
    public function __construct(
        Context $context,
        \MageWorx\GiftCards\Model\GiftCardsFactory $giftCardsFactory,
        \MageWorx\GiftCards\Model\GiftCardsRepository $giftCardsRepository
    ) {
    
        $this->formKeyValidator = $context->getFormKeyValidator();
        $this->giftCardsFactory = $giftCardsFactory;
        $this->giftCardsRepository = $giftCardsRepository;
        parent::__construct($context);
    }
   
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
       
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            $id = $this->getRequest()->getParam('card_id');

            if ($id) {
                $model = $this->giftCardsRepository->get($id);
            } else {
                $model = $this->giftCardsFactory->create();
                $model->setData([]);
                $model->isObjectNew(true);
            }
            $model->setData($data);
            
            if ($model->isObjectNew()) {
                $model->setId(null);
            }
           
            $this->_eventManager->dispatch(
                'mageworx_giftcards_prepare_save',
                ['giftcard' => $model, 'request'=>$this->getRequest()]
            );
           
            try {
                 $this->giftCardsRepository->save($model);
                 $this->messageManager->addSuccessMessage(__('Gift Card was saved'));
                 $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                 return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                   $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                   $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                   $this->messageManager->addError($e->getMessage());
                   $this->messageManager->addException($e, __('Something went wrong while saving the Gift Card.'));
            }

             $this->_getSession()->setFormData($data);
             return $resultRedirect->setPath('*/*/edit', ['card_id' => $this->getRequest()->getParam('card_id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MageWorx_GiftCards::mageworx_giftcards_giftcards');
    }
}
