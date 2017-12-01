<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Block;

use Magento\Sales\Api\OrderRepositoryInterface;

class PrintCard extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var mixed
     */
    protected $giftCard;

    /**
     * @var \Magento\Framework\Escaper
     */
    protected $escaper;

    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var \Magento\Checkout\Helper\Data
     */
    protected $checkoutHelper;

    /**
     * @var \MageWorx\GiftCards\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    protected $productImageModel;

    /**
     * @var \Magento\Framework\View\Asset\Repository
     */
    protected $assetRepo;
    
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Checkout\Helper\Data $checkoutHelper
     * @param \MageWorx\GiftCards\Helper\Data $helper
     * @param \Magento\Framework\Escaper $escaper
     * @param \Magento\Catalog\Helper\Image $productImageModel
     * @param OrderRepositoryInterface $orderRepository,
     * @param array $data
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Checkout\Helper\Data $checkoutHelper,
        \MageWorx\GiftCards\Helper\Data $helper,
        \Magento\Catalog\Helper\Image $productImageModel,
        OrderRepositoryInterface $orderRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_isScopePrivate = true;
        $this->registry = $registry;
        $this->giftCard = $this->registry->registry('mageworx_print_giftcard');
        $this->checkoutHelper = $checkoutHelper;
        $this->helper = $helper;
        $this->orderRepository = $orderRepository;
        $this->escaper  = $context->getEscaper();
        $this->productImageModel = $productImageModel;
        $this->assetRepo = $context->getAssetRepository();
    }
    
    public function getGiftCard()
    {
        return $this->giftCard;
    }
    
    public function getAmount()
    {
        return $this->checkoutHelper->formatPrice($this->giftCard->getCardAmount());
    }
    
    public function getFrontendName()
    {
        return $this->helper->getStoreName();
    }
    
    public function getOrder()
    {
        $order = null;
        if ($orderId = $this->giftCard->getOrderId()) {
            $order = $this->orderRepository->get($orderId);
        }
        return $order;
    }
    
    public function getProductImageUrl($orderItem)
    {
        $product = $orderItem->getProduct();
        $imageUrl = $this->productImageModel->init($product, 'image')->getUrl();
        return $imageUrl;
    }

    public function getDefaultImageUrl()
    {
        return $this->assetRepo->getUrl('MageWorx_GiftCards::images/giftcard.png');
    }
    
    public function getSupportMail()
    {
        return $this->helper->getSupportMail();
    }
    
    public function getPictureHtml()
    {
        return '<img src="' . $this->giftCard->getPictureUrl() . '" alt="" />';
    }
}
