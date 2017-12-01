<?php

/**
 * Copyright © 2016 Ihor Vansach (ihor@magefan.com). All rights reserved.
 * See LICENSE.txt for license details (http://opensource.org/licenses/osl-3.0.php).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magefan\Blog\Block\Post\PostList;

use Magento\Store\Model\ScopeInterface;

/**
 * Abstract blog post list block
 */
abstract class AbstractList extends \Magento\Framework\View\Element\Template {

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $_filterProvider;

    /**
     * @var \Magento\Cms\Model\Page
     */
    protected $_post;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magefan\Blog\Model\ResourceModel\Post\CollectionFactory
     */
    protected $_postCollectionFactory;

    /**
     * @var \Magefan\Blog\Model\ResourceModel\Post\Collection
     */
    protected $_postCollection;
    protected $_postAllCollection;
	protected $_postPopularCollection;

    /**
     * @var \Magefan\Blog\Model\Url
     */
    protected $_url;

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param \Magefan\Blog\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory
     * @param \Magefan\Blog\Model\Url $url
     * @param array $data
     */
    public function __construct(
    \Magento\Framework\View\Element\Template\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Cms\Model\Template\FilterProvider $filterProvider, \Magefan\Blog\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory, \Magefan\Blog\Model\Url $url, array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_coreRegistry = $coreRegistry;
        $this->_filterProvider = $filterProvider;
        $this->_postCollectionFactory = $postCollectionFactory;
        $this->_url = $url;
    }

    /**
     * Prepare posts collection
     *
     * @return void
     */
    protected function _preparePostCollection() {
        $this->_postCollection = $this->_postCollectionFactory->create()
                ->addActiveFilter()
                ->addStoreFilter($this->_storeManager->getStore()->getId())
                ->setOrder('publish_time', 'DESC');

        if ($this->getPageSize()) {
            $this->_postCollection->setPageSize($this->getPageSize());
        }
    }

    protected function _prepareAllPostCollection() {
        $this->_postAllCollection = $this->_postCollectionFactory->create()
                ->addActiveFilter()
                ->addStoreFilter($this->_storeManager->getStore()->getId())
                ->setOrder('publish_time', 'DESC')->setPageSize(1000);
    }
	protected function _preparePopularPostCollection() {
        $this->_postPopularCollection = $this->_postCollectionFactory->create()
                ->addActiveFilter()
                ->addStoreFilter($this->_storeManager->getStore()->getId())
                ->setOrder('views_count', 'DESC');

        if ($this->getPageSize()) {
            $this->_postPopularCollection->setPageSize($this->getPageSize());
        }
    }

    /**
     * Prepare posts collection
     *
     * @return \Magefan\Blog\Model\ResourceModel\Post\Collection
     */
    public function getPostCollection() {
        if (null === $this->_postCollection) {
            $this->_preparePostCollection();
        }

        return $this->_postCollection;
    }

    public function getAllPostCollection() {
        if (null === $this->_postAllCollection) {
            $this->_prepareAllPostCollection();
        }

        return $this->_postAllCollection;
    }
	
	public function getPopularPostCollection() {
        if (null === $this->_postPopularCollection) {
            $this->_preparePopularPostCollection();
        }

        return $this->_postPopularCollection;
    }


    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml() {
        if (!$this->_scopeConfig->getValue(
                        \Magefan\Blog\Helper\Config::XML_PATH_EXTENSION_ENABLED, ScopeInterface::SCOPE_STORE
                )) {
            return '';
        }

        return parent::_toHtml();
    }

}
