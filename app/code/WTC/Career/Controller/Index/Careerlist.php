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
class Careerlist extends Action
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
		Context $context,
		\Magento\Framework\Controller\Result\JsonFactory    $resultJsonFactory
    ) {
    
		parent::__construct($context);
        $this->actionFactory = $actionFactory;
		$this->_coreRegistry = $coreRegistry;
        $this->helper        = $helper;
		$this->_resultPageFactory = $pageFactory;
		$this->resultForwardFactory = $resultForwardFactory;
		$this->resultJsonFactory = $resultJsonFactory;
    }

	/**
	 * @return $this|\Magento\Framework\View\Result\Page
	 */
    public function execute()
    {
		if ($this->getRequest()->isAjax()) 
        {
			$data = $this->getRequest()->getPostValue();
			$category = $data['cat'];
			$list = $this->helper->getJoblist($category);
			$result = $this->resultJsonFactory->create();
			$html = "";
			if(count($list) > 0){
				foreach($list as $job){
					$url = '/career/'.$job->getUrl();
					$html .= '<li>';
					$html .= '<h4 class="title">';
					$html .= $job->getTitle();
					$html .= '</h4>';
					$html .= '<p class="info"><span class="location">';
					$html .= $job->getLocation();
					$html .= '</span>';
					//$onClick = "loadJob('".$url."')";
					$onClick = "return loadJob('".$url."','".$category."')";
					//$html .= '<a href="javascript:loadJob();" onClick="'.$onClick.'" class="btn btn-primary submit-button pull-right" class="view_posting_link">View Posting</a></p></li>';
					$html .= '<a href="javascript:void(0)" onClick="'.$onClick.'" class="btn btn-primary submit-button pull-right" class="view_posting_link">View Posting</a></p></li>';
				}
			}else{
				$html = "Currently there is no opening for this category";
			}
			echo $html;
            //return $result->setData($html);
        }else{
			$category = $this->getRequest()->getParam('category');
			if($category){
				$career = $this->helper->getJoblist($category);
				$this->_coreRegistry->register('joblist', $career);
				$this->_coreRegistry->register('job_category', $category);
				return $this->_resultPageFactory->create();
			}
			else{
				$resultRedirect = $this->resultRedirectFactory->create();
				return $resultRedirect->setPath('career');
			}
		}
    }

}
