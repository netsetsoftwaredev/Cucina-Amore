<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_Blog
 * @copyright   Copyright (c) 2016 Mageplaza (http://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */
namespace WTC\Career\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManagerInterface;
use WTC\Career\Helper\Data as HelperBlog;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Customer\Model\Session;
use Magento\Framework\Controller\Result\ForwardFactory;

/**
 * Class View
 * @package WTC\Career\Controller\Post
 */
class Jobs extends Action
{
	
	 /**
     * @var \Magento\Framework\App\ActionFactory
     */
    public $actionFactory;
    public $trafficFactory;

    /**
     * @var \Mageplaza\Blog\Helper\Data
     */
    public $helper;

    protected $_request;

    /**
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     * @param \Mageplaza\Blog\Helper\Data $helper
     */
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
		\WTC\Career\Helper\Data $helper,
		ForwardFactory $resultForwardFactory,
		\Magento\Framework\Registry $coreRegistry,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		Context $context
    ) {
    
		parent::__construct($context);
        $this->actionFactory = $actionFactory;
		$this->_coreRegistry = $coreRegistry;
        $this->helper        = $helper;
		$this->_resultPageFactory = $pageFactory;
		$this->resultForwardFactory = $resultForwardFactory;
    }

	/**
	 * @return $this|\Magento\Framework\View\Result\Page
	 */
    public function execute()
    {
		$data = $this->getRequest()->getPostValue();
        $category = $data['job_category'];
		$resultRedirect = $this->resultRedirectFactory->create();
		if($category){
			return $resultRedirect->setPath("career/$category");
		}
		return $resultRedirect->setPath("career");
    }

}
