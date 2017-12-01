<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Block\Adminhtml\GiftCards;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{

    protected $moduleManager;

    protected $giftCardsCollectionFactory;

    protected $cardType;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \MageWorx\GiftCards\Model\ResourceModel\GiftCards\CollectionFactory $giftCardsCollectionFactory,
        \MageWorx\GiftCards\Model\GiftCards\Source\TypesOptionProvider $cardType,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
    
        $this->giftCardsCollectionFactory = $giftCardsCollectionFactory;
        $this->cardType = $cardType;
        $this->moduleManager = $moduleManager;
        
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('giftcardsGrid');
        $this->setDefaultSort('card_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('giftcards_filter');
    }

    protected function _prepareCollection()
    {
        $collection = $this->giftCardsCollectionFactory->create();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'card_id',
            [
                'header' => __('ID'),
                'type'   => 'number',
                'index'  => 'card_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
                ]
        );

        $this->addColumn(
            'card_code',
            [
                'header' => __('Gift Card Code'),
                'type'   => 'text',
                'index'  => 'card_code',
                ]
        );

        $this->addColumn(
            'card_amount',
            [
                'header' => __('Initial Value'),
                'type'   => 'price',
                'index'  => 'card_amount',
                'currency' => 'card_currency',
                ]
        );

        $this->addColumn(
            'card_balance',
            [
                'header' => __('Current Balance'),
                'type'   => 'price',
                'index'  => 'card_balance',
                'currency' => 'card_currency',
                ]
        );

        $this->addColumn(
            'mail_to',
            [
                'header' => __('Recipient'),
                'type'   => 'text',
                'index'  => 'mail_to',
                ]
        );

        $this->addColumn(
            'mail_to_email',
            [
                'header'  => __('Recipient E-Mail'),
                'type'    => 'text',
                'index'   => 'mail_to_email',
                ]
        );

        $this->addColumn(
            'card_type',
            [
                'header' => __('Card Type'),
                'type'   => 'options',
                'index'  => 'card_type',
                'options' => $this->cardType->getOptionArray(),
                ]
        );

        $this->addColumn(
            'created_time',
            [
                'header' => __('Created At'),
                'index'  => 'created_at',
                'type'   => 'datetime',
                ]
        );

        $block = $this->getLayout()->getBlock('grid.bottom.links');

        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('mageworx_giftcards/*/grid', ['_current' => true]);
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('mageworx_giftcards/*/edit', ['card_id' => $row->getId()]);
    }
}
