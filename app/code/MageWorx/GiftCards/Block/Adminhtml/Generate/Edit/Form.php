<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Block\Adminhtml\Generate\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    protected $cardType;
    
    protected $cardStatus;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \MageWorx\GiftCards\Model\GiftCards\Source\TypesOptionProvider $cardType,
        \MageWorx\GiftCards\Model\GiftCards\Source\StatusesOptionProvider $cardStatus,
        array $data = []
    ) {
        $this->cardType       = $cardType;
        $this->cardStatus     = $cardStatus;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    public function _construct()
    {
        parent::_construct();
        $this->setId('generate_form');
        $this->setTitle(__('Gift Card Information'));
    }

    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'method' => 'post',
                    'action' => $this->getData('action'),
                ]
            ]
        );

        $form->setHtmlIdPrefix('giftcard_generate_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Generate Gift Cards')]);

        $fieldset->addField(
            'giftcards_count',
            'text',
            [
                'name' => 'giftcards_count',
                'label' => __('Giftcards Count'),
                'title' => __('Giftcards Count'),
                'required' => true,
            ]
        );

        $fieldset->addField(
            'giftcards_amount',
            'text',
            [
                'name' => 'giftcards_amount',
                'label' => __('Giftcards Amount'),
                'title' => __('Giftcards Amount'),
                'required' => true,
            ]
        );

        $fieldset->addField(
            'giftcards_type',
            'select',
            [
                'label' => __('Gift Card Type'),
                'title' => __('Gift Card Type'),
                'name' => 'giftcards_type',
                'options' => $this->cardType->getAllOptions(),
                'required' => true,
            ]
        );

        $fieldset->addField(
            'giftcards_status',
            'select',
            [
                'name' => 'giftcards_status',
                'label' => __('Giftcards Status'),
                'title' => __('Giftcards Status'),
                'options' => $this->cardStatus->getAllOptions(),
            ]
        );

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
