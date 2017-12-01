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
use WTC\Career\Model\TrafficFactory;
use Magento\Framework\Controller\Result\ForwardFactory;

/**
 * Class View
 * @package WTC\Career\Controller\Post
 */
class View extends Action
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
	 * @return $this|\Magento\Framework\View\Result\Page
	 */
    public function execute()
    {
		$id = $this->getRequest()->getParam('id');
        if($id){
            $trafficModel = $this->trafficFactory->create()->load($id, 'id');
            if ($trafficModel->getId()) {
                $trafficModel->setNumbersView($trafficModel->getNumbersView()+1);
                $trafficModel->save();
            } else {
                $traffic = $this->trafficFactory->create();
                $traffic->addData(['post_id' => $id, 'numbers_view' => 1])->save();
            }
        }
        return ($id) ? $this->resultPageFactory->create() : $this->resultForwardFactory->create()->forward('noroute');
    }

}
