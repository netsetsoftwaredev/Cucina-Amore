<?php
/**
 * @category Mageants StoreLocator
 * @package Mageants_StoreLocator
 * @copyright Copyright (c) 2017 Mageants
 * @author Mageants Team <support@Mageants.com>
 */
namespace Rocktechnolabs\CLP\Block;
use Magento\Framework\ObjectManagerInterface;

/**
 * Locator GoogleMap 
 */
class Clp extends \Magento\Framework\View\Element\Template
{
	/**
	 * Current Store Collection
	 *
	 * @var \Mageants\StoreLocator\Model\ManageStore
	 */
    protected $_clpCollection;

    protected $_objectManager;

    /**
	 * File System
	 *
	 * @var \Magento\Framework\Filesystem
	 */
	protected $_filesystem ;
	
    /**
	 * Image Factory
	 *
	 * @var \Magento\Framework\Image\AdapterFactory
	 */
	protected $_imageFactory;
	
	/**
	 * @param \Magento\Backend\Block\Template\Context 
	 * @param \Mageants\StoreLocator\Helper\Data
	 * @param \Mageants\StoreLocator\Model\ManageStore
	 * @param \Magento\Framework\Filesystem
	 * @param \Magento\Framework\Image\AdapterFactory
	 */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Rocktechnolabs\CLP\Model\CLP $clpCollection,
        \Rocktechnolabs\CLP\Model\Flavor $FlavorCollection,
        \Magento\Catalog\Model\ProductFactory $productCollection,
        ObjectManagerInterface $objectManager
 	){
 	   	$this->objectManager = $objectManager;
    	$this->_clpCollection = $clpCollection;
    	$this->_flavorCollection = $FlavorCollection;
    	$this->_productCollection=$productCollection;
        parent::__construct($context);
    }
    
	/**
	 * Prepare Layout
	 *
	 * @return Parent::_prepareLayout
	 */
    public function _prepareLayout()
    {
        //$this->pageConfig->getTitle()->set(__('Store Locator'));
        return parent::_prepareLayout();
    }

	/**
	 * Dispatch request
	 * 
	 * @param RequestInterface $request
	 * @return $dispatch
	 */
    public function dispatch(RequestInterface $request) 
    {
        return parent::dispatch($request);
    }

    public function getFlavorCollection()
    {
    	return $this->_flavorCollection;
    }

    public function getProductById($id)
    {
    	return $this->_productCollection->create()->load($id);;	
    }

    public function getClpCollection($clp_id)
    {
    	$Collection = $this->_clpCollection->getCollection()
                    ->addFieldToFilter('clp_id',array('in'=>$clp_id));
        return $Collection;
    }
    public function getMediaUrl()
    {
    	$media_dir = $this->objectManager->get('Magento\Store\Model\StoreManagerInterface')
                ->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return $media_dir;
    }
}
