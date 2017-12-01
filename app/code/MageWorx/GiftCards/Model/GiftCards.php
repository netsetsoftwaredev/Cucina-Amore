<?php

namespace MageWorx\GiftCards\Model;

use MageWorx\GiftCards\Api\Data\GiftCardsInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Mail\Template\FactoryInterface;

class GiftCards extends \Magento\Framework\Model\AbstractModel implements GiftCardsInterface, IdentityInterface
{
    
    const STATUS_INACTIVE    = 0;
    const STATUS_ACTIVE      = 1;
    const STATUS_USED        = 2;
    
    const STATUS_INACTIVE_LABEL    = 'Inactive';
    const STATUS_ACTIVE_LABEL      = 'Active';
    const STATUS_USED_LABEL        = 'Used';

    const TYPE_EMAIL         = 1;
    const TYPE_PRINT         = 2;
    const TYPE_OFFLINE       = 3;

    const TYPE_EMAIL_LABEL         = 'Email';
    const TYPE_PRINT_LABEL         = 'Print';
    const TYPE_OFFLINE_LABEL       = 'Offline';
    
    const CACHE_TAG          = 'mageworx_giftcards';
    
    protected $cacheTag     = 'mageworx_giftcards';
    
    protected $eventPrefix  = 'mageworx_giftcards';

    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;
    
    /**
     * @var \MageWorx\GiftCards\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\Checkout\Helper\Data
     */
    protected $checkoutHelper;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    protected $imageHelper;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var FactoryInterface
     */
    protected $factoryInterface;
    /**
     * @var \Magento\Framework\View\Asset\Repository
     */
    protected $assetRepo;

    /**
     * @var \Magento\Store\Model\App\Emulation
     */
    protected $appEmulation;

    /**
     * GiftCards constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \MageWorx\GiftCards\Helper\Data $helper
     * @param TransportBuilder $transportBuilder
     * @param FactoryInterface $templateFactory
     * @param \Magento\Framework\View\Asset\Repository $assetRepo
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Magento\Checkout\Helper\Data $checkoutHelper
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param \Magento\Store\Model\App\Emulation $appEmulation
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \MageWorx\GiftCards\Helper\Data $helper,
        TransportBuilder $transportBuilder,
        FactoryInterface $templateFactory,
        \Magento\Framework\View\Asset\Repository $assetRepo,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Checkout\Helper\Data $checkoutHelper,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Store\Model\App\Emulation $appEmulation,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->transportBuilder = $transportBuilder;
        $this->factoryInterface = $templateFactory;
        $this->helper = $helper;
        $this->urlBuilder = $urlBuilder;
        $this->assetRepo = $assetRepo;
        $this->checkoutHelper = $checkoutHelper;
        $this->imageHelper = $imageHelper;
        $this->productFactory = $productFactory;
        $this->appEmulation = $appEmulation;
    }

    protected function _construct()
    {
        $this->_init('MageWorx\GiftCards\Model\ResourceModel\GiftCards');
    }

    /**
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [
            self::STATUS_INACTIVE => __('Inactive'),
            self::STATUS_ACTIVE => __('Active'),
            self::STATUS_USED => __('Used')
        ];
    }

    /**
     * @return array
     */
    public function getCardTypes()
    {
        return [self::TYPE_EMAIL => __('Email'), self::TYPE_PRINT => __('Print'), self::TYPE_OFFLINE => __('Offline')];
    }
    
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
    
    public function getId()
    {
        return $this->getData(self::CARD_ID);
    }
    
    public function getCardCode()
    {
        return $this->getData(self::CARD_CODE);
    }
    
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }
    
    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }
    
    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }
    
    public function getCardCurrency()
    {
        return $this->getData(self::CARD_CURRENCY);
    }
    
    public function getCardAmount()
    {
        return $this->getData(self::CARD_AMOUNT);
    }

    public function getCardBalance()
    {
        return $this->getData(self::CARD_BALANCE);
    }
    
    public function getCardStatus()
    {
        return $this->getData(self::CARD_STATUS);
    }

    public function getCardStatusLabel()
    {
        $status = $this->getCardStatus();
        
        if ($status == self::STATUS_INACTIVE) {
            return self::STATUS_INACTIVE_LABEL;
        } elseif ($status == self::STATUS_ACTIVE) {
            return self::STATUS_ACTIVE_LABEL;
        } else {
            return self::STATUS_USED_LABEL;
        }
    }
    
    public function getCardType()
    {
        return $this->getData(self::CARD_TYPE);
    }

    public function getCardTypeLabel()
    {
        $type = $this->getCardType();
        
        if ($type == self::TYPE_EMAIL) {
            return self::TYPE_EMAIL_LABEL;
        } elseif ($type == self::TYPE_PRINT) {
            return self::TYPE_PRINT_LABEL;
        } else {
            return self::TYPE_OFFLINE_LABEL;
        }
    }
    
    public function getMailFrom()
    {
        return $this->getData(self::MAIL_FROM);
    }
    
    public function getMailTo()
    {
        return $this->getData(self::MAIL_TO);
    }
    
    public function getMailToEmail()
    {
        return $this->getData(self::MAIL_TO_EMAIL);
    }
    
    public function getMailMessage()
    {
        return $this->getData(self::MAIL_MESSAGE);
    }
    
    public function getOfflineCountry()
    {
        return $this->getData(self::OFFLINE_COUNTRY);
    }
    
    public function getOfflineState()
    {
        return $this->getData(self::OFFLINE_STATE);
    }
    
    public function getOfflineCity()
    {
        return $this->getData(self::OFFLINE_CITY);
    }

    public function getOfflineStreet()
    {
        return $this->getData(self::OFFLINE_STREET);
    }

    public function getOfflineZip()
    {
        return $this->getData(self::OFFLINE_ZIP);
    }

    public function getOfflinePhone()
    {
        return $this->getData(self::OFFLINE_PHONE);
    }

    public function getMailDeliveryDate()
    {
        return $this->getData(self::MAIL_DELIVERY_DATE);
    }
    
    public function getCreatedTime()
    {
        return $this->getData(self::CREATED_TIME);
    }
    
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }
    
    
    public function setId($id)
    {
        return $this->setData(self::CARD_ID, $id);
    }
    
    public function setCardCode($cardCode)
    {
        return $this->setData(self::CARD_CODE, $cardCode);
    }
    
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }
    
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }
    
    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }
    
    public function setCardCurrency($cardCurrency)
    {
        return $this->setData(self::CARD_CURRENCY, $cardCurrency);
    }
    
    public function setCardAmount($cardAmount)
    {
        return $this->setData(self::CARD_AMOUNT, $cardAmount);
    }

    public function setCardBalance($cardBalance)
    {
        return $this->setData(self::CARD_BALANCE, $cardBalance);
    }
    
    public function setCardStatus($cardStatus)
    {
        return $this->setData(self::CARD_STATUS, $cardStatus);
    }
    
    public function setCardType($cardType)
    {
        return $this->setData(self::CARD_TYPE, $cardType);
    }
    
    public function setMailFrom($mailFrom)
    {
        return $this->setData(self::MAIL_FROM, $mailFrom);
    }
    
    public function setMailTo($mailTo)
    {
        return $this->setData(self::MAIL_TO, $mailTo);
    }
    
    public function setMailToEmail($mailToEmail)
    {
        return $this->setData(self::MAIL_TO_EMAIL, $mailToEmail);
    }
    
    public function setMailMessage($mailMessage)
    {
        return $this->setData(self::MAIL_MESSAGE, $mailMessage);
    }
    
    public function setOfflineCountry($offlineCountry)
    {
        return $this->setData(self::OFFLINE_COUNTRY, $offlineCountry);
    }
    
    public function setOfflineState($offlineState)
    {
        return $this->setData(self::OFFLINE_STATE, $offlineState);
    }
    
    public function setOfflineCity($offlineCity)
    {
        return $this->setData(self::OFFLINE_CITY, $offlineCity);
    }

    public function setOfflineStreet($offlineStreet)
    {
        return $this->setData(self::OFFLINE_STREET, $offlineStreet);
    }

    public function setOfflineZip($offlineZip)
    {
        return $this->setData(self::OFFLINE_ZIP, $offlineZip);
    }

    public function setOfflinePhone($offlinePhone)
    {
        return $this->setData(self::OFFLINE_PHONE, $offlinePhone);
    }

    public function setMailDeliveryDate($mailDeliveryDate)
    {
        return $this->setData(self::MAIL_DELIVERY_DATE, $mailDeliveryDate);
    }
    
    public function setCreatedTime($createdTime)
    {
        return $this->setData(self::CREATED_TIME, $createdTime);
    }
    
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    public function activateCard()
    {
        $this->setCardStatus(self::STATUS_ACTIVE);
        return true;
    }

    public function sendNoOrder()
    {
        $templateVars = [
             'amount'        => $this->checkoutHelper->formatPrice($this->getCardAmount()),
             'code'          => $this->getCardCode(),
             'email-to'      => $this->getMailTo(),
             'email-from'    => $this->getMailFrom(),
             'recipient'     => $this->getMailToEmail(),
             'email-message' => nl2br($this->getMailMessage()),
             'store-phone'   => $this->helper->getStorePhone(),
             'picture'       => $this->getGiftCardPicture(),
        ];

        $this->transportBuilder->setTemplateIdentifier('mageworx_giftcards_email_email_template');
        $this->transportBuilder->setTemplateVars($templateVars);
        $this->transportBuilder->setFrom('general');
        $this->transportBuilder->addTo($this->getMailToEmail(), $this->getMailTo());
        $this->transportBuilder->setTemplateOptions([
            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
            'store' => 1,
        ]);
    }

    /**
     * @param \Magento\Sales\Model\Order $order
     * @return void
     */
    public function send(\Magento\Sales\Model\Order $order)
    {
        $type = $this->getCardType();
        switch ($type) {
            case self::TYPE_EMAIL:
                $this->prepareEmailCard($order);
                break;
            case self::TYPE_PRINT:
                $this->preparePrintCard($order);
                break;
            case self::TYPE_OFFLINE:
                $this->prepareOfflineCard($order);
                break;
            default:
                $this->prepareEmailCard($order);
                break;
        }
        $transport = $this->transportBuilder->getTransport();
        $transport->sendMessage();
    }

    /**
     * @param \Magento\Sales\Model\Order $order
     * @return $this
     */
    protected function prepareEmailCard($order)
    {
        $templateVars = [
             'amount'        => $this->checkoutHelper->formatPrice($this->getCardAmount()),
             'code'          => $this->getCardCode(),
             'email-to'      => $this->getMailTo(),
             'email-from'    => $this->getMailFrom(),
             'recipient'     => $this->getMailToEmail(),
             'email-message' => nl2br($this->getMailMessage()),
             'store-phone'   => $this->helper->getStorePhone(),
             'picture'       => $this->getGiftCardPicture($order->getStoreId()),
        ];

        $this->transportBuilder->setTemplateIdentifier('mageworx_giftcards_email_email_template');
        $this->transportBuilder->setTemplateVars($templateVars);
        $this->transportBuilder->setFrom('general');
        $this->transportBuilder->addTo($this->getMailToEmail(), $this->getMailTo());
        $this->transportBuilder->setTemplateOptions([
            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
            'store' => $order->getStoreId()
        ]);

        return $this;
    }

    /**
     * @param \Magento\Sales\Model\Order $order
     * @return $this
     */
    protected function preparePrintCard($order)
    {
        $templateVars = [
             'amount'        => $this->checkoutHelper->formatPrice($this->getCardAmount()),
             'code'          => $this->getCardCode(),
             'email-to'      => $this->getMailTo(),
             'email-from'    => $this->getMailFrom(),
             'recipient'     => $order->getCustomerEmail(),
             'email-message' => nl2br($this->getMailMessage()),
             'store-phone'   => $this->helper->getStorePhone(),
             'picture'       => $this->getGiftCardPicture($order->getStoreId()),
             'link'          => $this->urlBuilder->getBaseUrl() . 'mageworx_giftcards/giftcards/printCard/code/'. $this->getCardCode(),
             'customer-name' => $order->getCustomerName()
        ];

        $this->transportBuilder->setTemplateIdentifier('mageworx_giftcards_email_print_template');
        $this->transportBuilder->setTemplateVars($templateVars);
        $this->transportBuilder->setFrom('general');
        $this->transportBuilder->addTo($order->getCustomerEmail(), $this->getMailTo());
        $this->transportBuilder->setTemplateOptions([
            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
            'store' => $order->getStoreId()
        ]);

        return $this;
    }

    /**
     * @param \Magento\Sales\Model\Order $order
     * @return $this
     */
    protected function prepareOfflineCard($order)
    {
        $templateVars = [
             'amount'        => $this->checkoutHelper->formatPrice($this->getCardAmount()),
             'code'          => $this->getCardCode(),
             'email-to'      => $this->getMailTo(),
             'email-from'    => $this->getMailFrom(),
             'recipient'     => $order->getCustomerEmail(),
             'email-message' => nl2br($this->getMailMessage()),
             'store-phone'   => $this->helper->getStorePhone(),
             'picture'       => $this->getGiftCardPicture($order->getStoreId()),
        ];

        $this->transportBuilder->setTemplateIdentifier('mageworx_giftcards_email_offline_template');
        $this->transportBuilder->setTemplateVars($templateVars);
        $this->transportBuilder->setFrom('general');
        $this->transportBuilder->addTo($order->getCustomerEmail(), $this->getMailTo());
        $this->transportBuilder->setTemplateOptions([
            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
            'store' => $order->getStoreId()
        ]);

        return $this;
    }

    /**
     * @param int|null $storeId
     * @return string
     */
    protected function getGiftCardPicture($storeId = null)
    {
        if ($storeId !== null) {
            $this->appEmulation->startEnvironmentEmulation($storeId, \Magento\Framework\App\Area::AREA_FRONTEND, true);
        }

        if ($productId = $this->getProductId()) {
            $product = $this->productFactory->create()->load($productId);
            $picture = $this->imageHelper->init($product, 'mageworx_giftcards_main_image')->getUrl();
        } else {
            $picture = $this->assetRepo->getUrl('MageWorx_GiftCards::images/giftcard.png');
        }
        
        if (strpos($picture, 'placeholder') !== false) {
            $picture = $this->assetRepo->getUrl('MageWorx_GiftCards::images/giftcard.png');
        }

        if ($storeId !== null) {
            $this->appEmulation->stopEnvironmentEmulation();
        }

        return $picture;
    }
    
    public function preview($data)
    {
        if ($productId = $data['product']) {
            $product = $this->productFactory->create()->load($productId);
            $picture = $this->imageHelper->init($product, 'mageworx_giftcards_main_image')->getUrl();
        } else {
            $picture = $this->assetRepo->getUrl('MageWorx_GiftCards::images/giftcard.png');
        }

        if (strpos($picture, 'placeholder') === true) {
            $picture = $this->assetRepo->getUrl('MageWorx_GiftCards::images/giftcard.png');
        }
        
        $templateVars = [
             'amount'        => $this->checkoutHelper->formatPrice($data['price']),
             'code'          => 'XXXX-XXXX-XXXX',
             'email-to'      => $data['mail-to'],
             'email-from'    => $data['mail-from'],
             'recipient'     => $data['mail-to-email'],
             'email-message' => nl2br($data['mail-message']),
             'picture'       => $picture,
        ];

        $template = $this->factoryInterface->get('mageworx_giftcards_email_email_template', '')
            ->setVars($templateVars)
            ->setOptions([
            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
            'store' => 1
            ]);
            
        $body = $template->processTemplate();
        return $body;
    }
    
    public function getPictureUrl()
    {
        return $this->getGiftCardPicture();
    }
}
