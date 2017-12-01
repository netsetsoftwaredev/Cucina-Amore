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
namespace WTC\Career\Controller;

/**
 * Class Router
 * @package Mageplaza\Blog\Controller
 */
class Router implements \Magento\Framework\App\RouterInterface
{
    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    public $actionFactory;

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
		\WTC\Career\Helper\Data $helper
    ) {
    

        $this->actionFactory = $actionFactory;
        $this->helper        = $helper;
    }

    /**
     * Validate and Match Cms Page and modify request
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return bool
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
		$identifier = trim($request->getPathInfo(), '/');
        $routePath  = explode('/', $identifier);
		if(in_array("career", $routePath)){
			if(isset($routePath[1])){
				$url = $routePath[1];
				$params     = [];
				$controller = array_shift($routePath);

				if (!$controller) {
					return $this->_forward('career', 'index');
				}
				$career = $this->helper->getJobByUrl($url);
				$action = 'view';
				$id = $career->getId();
				if($id)
				{
					$request->setModuleName('career')->setControllerName('index')->setActionName("view")->setParam('id', $id);
				}elseif($url == "jobs"){
					$request->setModuleName('career')->setControllerName('index')->setActionName("jobs")->setParam('category', $_POST['job_category']);
				}
				else{
					$request->setModuleName('career')->setControllerName('index')->setActionName("careerlist")->setParam('category', $url);
				}
				
				return $this->actionFactory->create(
					'Magento\Framework\App\Action\Forward',
					['request' => $request]
				);
			}
		}
    }
}
