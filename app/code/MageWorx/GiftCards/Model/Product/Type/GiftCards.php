<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

/**
 * Giftcards product type implementation
 *
 * @author     MageWorx Dev Team
 */
namespace MageWorx\GiftCards\Model\Product\Type;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class GiftCards extends \Magento\Catalog\Model\Product\Type\AbstractType
{

    const TYPE_CODE = 'mageworx_giftcards';

    protected $storeManager;

    /** var@ MageWorx\GiftCards\Model\Helper\Data */
    protected $helper;

    public function __construct(
        \Magento\Catalog\Model\Product\Option $catalogProductOption,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Catalog\Model\Product\Type $catalogProductType,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\MediaStorage\Helper\File\Storage\Database $fileStorageDb,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Registry $coreRegistry,
        \Psr\Log\LoggerInterface $logger,
        ProductRepositoryInterface $productRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \MageWorx\GiftCards\Helper\Data $helper
    ) {
    
        parent::__construct(
            $catalogProductOption,
            $eavConfig,
            $catalogProductType,
            $eventManager,
            $fileStorageDb,
            $filesystem,
            $coreRegistry,
            $logger,
            $productRepository
        );
        $this->storeManager = $storeManager;
        $this->helper  = $helper;
    }
    
    public function processBuyRequest($product, $buyRequest)
    {
        $data = parent::processBuyRequest($product, $buyRequest);
        $data['card_amount']        = $buyRequest->getCardAmount();
        $data['card_currency']      = $buyRequest->getCardCurrency();
        $data['mail_to']            = $buyRequest->getMailTo();
        $data['mail_to_email']      = $buyRequest->getMailToEmail();
        $data['mail_from']          = $buyRequest->getMailFrom();
        $data['mail_message']       = $buyRequest->getMailMessage();
        $data['offline_country']    = $buyRequest->getOfflineCountry();
        $data['offline_state']      = $buyRequest->getOfflineState();
        $data['offline_city']       = $buyRequest->getOfflineCity();
        $data['offline_street']     = $buyRequest->getOfflineStreet();
        $data['offline_zip']        = $buyRequest->getOfflineZip();
        $data['offline_phone']      = $buyRequest->getOfflinePhone();
        $data['mail_delivery_date'] = $buyRequest->getMailDeliveryDate();
        return $data;
    }
    
    protected function _prepareProduct(\Magento\Framework\DataObject $buyRequest, $product, $processMode)
    {
        $data = $buyRequest->getData();
        $cardType = $product->getData('mageworx_gc_type');

        //change delivery date to mysql format
        if (!empty($data['mail_delivery_date'])) {
            $tempDate = explode('/', $data['mail_delivery_date']);
            $mailDeliveryDate = $tempDate[2].'-'.$tempDate[0].'-'.$tempDate[1];
        } else {
            $mailDeliveryDate = null;
        }


        /*
         * Validate card amount
         * TODO: Need options validation
         */
        if (!$product->getData('price')) {
            // true only if min value is set (more than 0) and price less than min
            $min = $this->helper->getMinCardValue() > 0 && $data['card_amount'] < $this->helper->getMinCardValue();
            // true only if max value is set (more than 0) and price more than max
            $max = $this->helper->getMaxCardValue() > 0 && $data['card_amount'] > $this->helper->getMaxCardValue();
            // if one of conditions above is true than return error
            if ($min || $max) {
                return $this->getSpecifyPriceMessage()->render();
            }
            $product->setData('price', $data['card_amount']);
        }

        
        if ((!isset($data['card_amount']) && !$product->getData('price') ) || !isset($data['mail_to'])) {
            return $this->getSpecifyOptionsMessage()->render();
        }

        /*
         * Add gift card params as product custom options to product quote
         * TODO: Need options validation
         */
        $product->addCustomOption('card_type', $cardType);
        $product->addCustomOption('card_amount', isset($data['card_amount']) ? $data['card_amount'] : $product->getPrice());
        $product->addCustomOption('card_currency', $this->storeManager->getStore()->getCurrentCurrencyCode());
        $product->addCustomOption('mail_to', isset($data['mail_to']) ? $data['mail_to'] : '');
        $product->addCustomOption('mail_to_email', isset($data['mail_to_email']) ? $data['mail_to_email'] : '');
        $product->addCustomOption('mail_from', isset($data['mail_from']) ? $data['mail_from'] : '');
        $product->addCustomOption('mail_message', isset($data['mail_message']) ? $data['mail_message'] : '');
        $product->addCustomOption('offline_country', isset($data['offline_country']) ? $data['offline_country'] : '');
        $product->addCustomOption('offline_state', isset($data['offline_state']) ? $data['offline_state'] : '');
        $product->addCustomOption('offline_city', isset($data['offline_city']) ? $data['offline_city'] : '');
        $product->addCustomOption('offline_street', isset($data['offline_street']) ? $data['offline_street'] : '');
        $product->addCustomOption('offline_zip', isset($data['offline_zip']) ? $data['offline_zip'] : '');
        $product->addCustomOption('offline_phone', isset($data['offline_phone']) ? $data['offline_phone'] : '');
        $product->addCustomOption('mail_delivery_date', $mailDeliveryDate);//delivery date of email
        
        return parent::_prepareProduct($buyRequest, $product, $processMode);
    }

    public function getSpecifyPriceMessage()
    {
        return __('Card amount is not within the specified range.');
    }

    public function getSpecifyOptionsMessage()
    {
        return __('You need to choose options for your item.');
    }

    public function isVirtual($product)
    {
        if ($product->getCustomOption('card_type')->getValue() == \MageWorx\GiftCards\Model\GiftCards::TYPE_OFFLINE) {
            return false;
        }
        return true;
    }
    
    public function deleteTypeSpecificData(\Magento\Catalog\Model\Product $product)
    {
        return $this;
    }
}
