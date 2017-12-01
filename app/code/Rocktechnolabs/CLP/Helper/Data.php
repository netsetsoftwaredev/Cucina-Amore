<?php
/**
 * @category Rocktechnolabs CLP
 * @package Rocktechnolabs_CLP
 * @copyright Copyright (c) 2017 Rocktechnolabs
 * @author Rocktechnolabs Team <support@rocktechnolabs.com>
 */
namespace Rocktechnolabs\CLP\Helper;

/**
 * Helper Data 
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    protected $_backendUrl;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface 
     */
    protected $storeManager;
    
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface 
     */
    protected $scopeConfig;

    /**
     * @param \Magento\Framework\App\Helper\Context
     * @param \Magento\Backend\Model\UrlInterface 
     * @param \Magento\Store\Model\StoreManagerInterface 
     * @param \Magento\Framework\App\Config\ScopeConfigInterface
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) 
    {
        parent::__construct($context);
        $this->_backendUrl = $backendUrl;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $context->getScopeConfig();
    }

    /**
     * get products tab Url in admin
     *
     * @return string
     */
    public function getProductsGridUrl()
    {
        return $this->_backendUrl->getUrl('clp/clp/products', ['_current' => true]);
    }

    /**
     * get products tab Url in admin
     *
     * @return string
     */
    public function getFlavorProductsGridUrl()
    {
        return $this->_backendUrl->getUrl('clp/flavor/products', ['_current' => true]);
    }
    
    /**
     * Get CLP Config Value
     *
     * @return string
     */

   /* public function getConfigValue($config_path)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }*/
}
