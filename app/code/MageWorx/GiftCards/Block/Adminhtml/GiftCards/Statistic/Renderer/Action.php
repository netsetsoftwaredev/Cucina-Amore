<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Block\Adminhtml\GiftCards\Statistic\Renderer;

/**
 * Adminhtml giftcard order grid block action item renderer
 */
use Magento\Sales\Api\OrderRepositoryInterface;

class Action extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    protected $orderRepository;

    /**
     * @param \Magento\Backend\Block\Context $context
     * @param \Magento\Framework\Registry $registry
     * $param OrderRepositoryInterface $orderRepository,
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Framework\Registry $registry,
        OrderRepositoryInterface $orderRepository,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        $this->orderRepository = $orderRepository;
        parent::__construct($context, $data);
    }

    /**
     * @param \Magento\Framework\DataObject $row
     * @return string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        
        $incrementId = $this->orderRepository->get($row->getOrderId())->getIncrementId();
        ;
        $actions = [];

        $actions[] = [
            '@' => [
                'href' => $this->getUrl(
                    'sales/order/view',
                    [
                        'order_id' => $row->getOrderId(),
                    ]
                ),
                'target' => '_blank',
            ],
            '#' => $incrementId,
        ];

        return $this->_actionsToHtml($actions);
    }

    /**
     * @param string $value
     * @return string
     */
    protected function _getEscapedValue($value)
    {
        return addcslashes(htmlspecialchars($value), '\\\'');
    }

    /**
     * @param array $actions
     * @return string
     */
    protected function _actionsToHtml(array $actions)
    {
        $html = [];
        $attributesObject = new \Magento\Framework\DataObject();
        foreach ($actions as $action) {
            $attributesObject->setData($action['@']);
            $html[] = '<a ' . $attributesObject->serialize() . '>' . $action['#'] . '</a>';
        }
        return implode('<span class="separator">&nbsp;|&nbsp;</span>', $html);
    }
}
