<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.webtechnologycodes.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Web Technology Codes
 * @package     WTC_Career
 * @copyright   Copyright (c) 2016 Web Technology Codes (http://www.webtechnologycodes.com/)
 * @license     https://www.webtechnologycodes.com/LICENSE.html
 */
namespace WTC\Career\Helper;

use WTC\Career\Model\CareerFactory as CareerFactory;
use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\App\Helper\AbstractHelper;
/**
 * Class Data
 * @package WTC\Career\Helper
 */
class Data extends AbstractHelper
{
    public $careerCollectionFactory;

	public $careerfactory;

    public function __construct(
        
        \Magento\Framework\App\Helper\Context $context,
        CareerFactory $careerfactory,
        TemplateContext $templateContext,
		ObjectManagerInterface $objectManager,
        \WTC\Career\Model\ResourceModel\Career\CollectionFactory $careerCollectionFactory
    ) {
        $this->careerfactory     = $careerfactory;
        $this->careerCollectionFactory = $careerCollectionFactory;
        parent::__construct($context, $objectManager, $templateContext->getStoreManager());
    }

    public function getJoblist($category = null)
    {
        $jobs         = $this->careerfactory->create();
		$list = $jobs->getCollection();

        if ($list->getSize()) {
            $list->addFieldToFilter('is_active', 1);
			if($category){
				$list->addFieldToFilter('category', $category);
			}
            return $list;
        }
        return '';
    }

    /**
     * get url by post
     * @param $post
     * @return string
     */
    public function getUrlByPost($post)
    {
        $urlKey = '';
        if ($post->getUrlKey()) {
            $url_prefix = $this->getBlogConfig('general/url_prefix') ?: self::DEFAULT_URL_PREFIX;
            $url_suffix = $this->getBlogConfig('general/url_suffix');

            if ($url_prefix) {
                $urlKey .= $url_prefix . '/post/';
            }
            $urlKey .= $post->getUrlKey();
            if ($url_suffix) {
                $urlKey .= $url_suffix;
            }
        }

        return $this->_getUrl($urlKey);
    }

    /**
     * get blog url
     * @param $code
     * @return string
     */
    public function getBlogUrl($code)
    {
        $blogUrl = $this->getBlogConfig('general/url_prefix') ?: self::DEFAULT_URL_PREFIX;
        return $this->_getUrl($blogUrl . '/' . $code);
    }

    /**
     * get post by url
     * @param $url
     * @return \WTC\Career\Model\Career | null
     */
    public function getJobByUrl($url)
    {
        $career = $this->careerfactory->create()->load($url, 'url');
        return $career;
    }

    /**
     * get post by id
     * @param $id
     * @return \Mageplaza\Blog\Model\Post | null
     */
    public function getJob($id)
    {
        $job = $this->careerfactory->create()->load($id);
        return $job;
    }

	/**
	 * @return string
	 */
    public function getCurrentDate()
    {
        return $this->dateTime->date();
    }
}
