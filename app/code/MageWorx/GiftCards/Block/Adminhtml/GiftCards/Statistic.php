<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Block\Adminhtml\GiftCards;

class Statistic extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry|null
     */
    protected $coreRegistry = null;

    protected $collectionFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Framework\Registry $coreRegistry,
        \MageWorx\GiftCards\Model\ResourceModel\Order\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('orderGrid');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('desc');

        $this->setUseAjax(true);

        $this->setEmptyText(__('No Orders Found'));
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return '';
    }

     /**
     * @return $this
     */

    protected function _prepareCollection()
    {
        $giftcard = $this->coreRegistry->registry('mageworx_current_giftcard');
        $collection = $this->collectionFactory->create()
                                               ->addFieldToFilter('giftcard_id', $giftcard->getId())
                                               ->load();

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'action',
            [
                'header' => __('Order #'),
                'align' => 'center',
                'renderer' => 'MageWorx\GiftCards\Block\Adminhtml\GiftCards\Statistic\Renderer\Action',
            ]
        );

        $this->addColumn(
            'discounted',
            [
                'header' => __('Used Amount'),
                'type'   => 'currency',
                'align' => 'right',
                'index' => 'discounted',
                'currency_code' => (string)$this->_scopeConfig->getValue(
                    \Magento\Directory\Model\Currency::XML_PATH_CURRENCY_BASE,
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                ),
            ]
        );

        $this->addColumn(
            'created_time',
            [
                'header' => __('Create Date'),
                'type' => 'datetime',
                'align' => 'center',
                'index' => 'created_time',
                'gmtoffset' => true,
            ]
        );

        $this->addColumn(
            'updated_at',
            [
                'header' => __('Update Date'),
                'type' => 'datetime',
                'align' => 'center',
                'index' => 'updated_at',
                'gmtoffset' => true,
            ]
        );
        return parent::_prepareColumns();
    }
}
