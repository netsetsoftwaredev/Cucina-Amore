<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Block\Adminhtml\GiftCards\Edit;

/**
 * Adminhtml giftcard edit form block
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{

    protected $formValues = [];

    protected $localeCurrency;
    
    protected $systemStore;
    
    protected $cardType;
    
    protected $cardStatus;

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Framework\Locale\CurrencyInterface $localeCurrency,
     * @param \Magento\Store\Model\System\Store $systemStore,
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\Locale\CurrencyInterface $localeCurrency,
        \Magento\Store\Model\System\Store $systemStore,
        \MageWorx\GiftCards\Model\GiftCards\Source\TypesOptionProvider $cardType,
        \MageWorx\GiftCards\Model\GiftCards\Source\StatusesOptionProvider $cardStatus,
        array $data = []
    ) {
        $this->localeCurrency = $localeCurrency;
        $this->systemStore    = $systemStore;
        $this->cardType       = $cardType;
        $this->cardStatus     = $cardStatus;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    public function _construct()
    {
        parent::_construct();
        $this->setId('giftcard_form');
        $this->setTitle(__('Gift Card Information'));
    }

    protected function _initFormValues()
    {
        $model = $this->_getModel();

        if ($model) {
            $this->_formValues = [
                'card_id' => $model->getId(),
                'card_code' => $model->getCardCode(),
                'card_amount' => $model->getCardAmount(),
                'card_balance' => $model->getCardBalance(),
                'card_currency' => $model->getCardCurrency(),
                'card_type' => $model->getCardType(),
                'card_status' => $model->getCardStatus(),
                'mail_to' => $model->getMailTo(),
                'mail_to_email' => $model->getMailToEmail(),
                'mail_from' => $model->getMailFrom(),
                'mail_message' => $model->getMailMessage(),
            ];
        } else {
            $this->_formValues = [
                'card_id' => '',
                'card_code' => '',
                'card_amount' => '',
                'card_balance' => '',
                'card_currency' => '',
                'card_type' => '',
                'card_status' => '',
                'mail_to' => '',
                'mail_to_email' => '',
                'mail_from' => '',
                'mail_message' => '',
            ];
        }

        return $this;
    }

    /**
     * Prepare the form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $this->_initFormValues();

        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getData('action'),
                    'method' => 'post',
                ],
            ]
        );
        
        $form->setHtmlIdPrefix('giftcard_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Gift Card Info')]);

        $fieldset->addField(
            'card_id',
            'hidden',
            [
                'name' => 'card_id',
                'value' => $this->_formValues['card_id']
            ]
        );

        $fieldset->addField(
            'giftcard_id',
            'hidden',
            [
                'name' => 'giftcard_id',
                'value' => $this->_formValues['card_id']
            ]
        );

        $fieldset->addField(
            'card_code',
            'text',
            [
                'label' => __('Gift Card Code'),
                'title' => __('Gift Card Code'),
                'name' => 'card_code',
                'required' => false,
                'disabled' => true,
                'value' => $this->_formValues['card_code']
            ]
        );

        $fieldset->addField(
            'card_amount',
            'text',
            [
                'label' => __('Initial value'),
                'title' => __('Initial value'),
                'name' => 'card_amount',
                'required' => true,
                'disabled' => false,
                'value' => $this->_formValues['card_amount']
            ]
        );

        $fieldset->addField(
            'card_balance',
            'text',
            [
                'label' => __('Current Balance'),
                'title' => __('Current Balance'),
                'name' => 'card_balance',
                'required' => false,
                'disabled' => false,
                'value' => $this->_formValues['card_balance']
            ]
        );

        $fieldset->addField(
            'card_currency',
            'text',
            [
                'label' => __('Gift Card Currency'),
                'title' => __('Gift Card Currency'),
                'name' => 'card_currency',
                'value' => $this->_formValues['card_currency'],
                'note' => 'i.e. USD, EUR',
            ]
        );

        $fieldset->addField(
            'card_status',
            'select',
            [
                'label' => __('Gift Card Status'),
                'title' => __('Gift Card Status'),
                'name' => 'card_status',
                'options' => $this->cardStatus->getAllOptions(),
                'value' => $this->_formValues['card_status'],
            ]
        );

        $fieldset->addField(
            'card_type',
            'select',
            [
                'label' => __('Gift Card Type'),
                'title' => __('Gift Card Type'),
                'name' => 'card_type',
                'options' => $this->cardType->getAllOptions(),
                'value' => $this->_formValues['card_type'],
            ]
        );

        $recFieldset = $form->addFieldset('recipient_fieldset', ['legend' => __('Recipient Info')]);

        $recFieldset->addField(
            'mail_to',
            'text',
            [
                'label' => __('To Name'),
                'title' => __('To Name'),
                'name' => 'mail_to',
                'value' => $this->_formValues['mail_to']
            ]
        );

        $recFieldset->addField(
            'mail_to_email',
            'text',
            [
                'label' => __('To Email'),
                'title' => __('To Email'),
                'name' => 'mail_to_email',
                'value' => $this->_formValues['mail_to_email']
            ]
        );

        $recFieldset->addField(
            'mail_from',
            'text',
            [
                'label' => __('From Name'),
                'title' => __('From Name'),
                'name' => 'mail_from',
                'value' => $this->_formValues['mail_from']
            ]
        );

        $recFieldset->addField(
            'mail_message',
            'textarea',
            [
                'label' => __('Mail Message'),
                'title' => __('Mail Message'),
                'name' => 'mail_message',
                'cols' => 20,
                'rows' => 5,
                'value' => $this->_formValues['mail_message'],
                'wrap' => 'soft'
            ]
        );

        $form->setValues($this->_formValues);
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Get Giftcard model instance
     *
     * @return \MageWorx\GiftCards\Model\GiftCards
     */
    protected function _getModel()
    {
        return $this->_coreRegistry->registry('mageworx_current_giftcard');
    }
    
    public function getTabLabel()
    {
        return __('Main Information');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Main Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
}
