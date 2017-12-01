<?php
/**
 * Copyright © 2017 Ihor Vansach (ihor@magefan.com). All rights reserved.
 * See LICENSE.txt for license details (http://opensource.org/licenses/osl-3.0.php).
 *
 * Glory to Ukraine! Glory to the heroes!
 */
namespace Magefan\Blog\Controller\Index;
use Magento\Framework\View\Result\PageFactory;
/**
 * Blog home page view
 */
class Blogprint extends \Magefan\Blog\App\Action\Action
{
    /**
     * Result PageFactory
     *
     * @var Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;
    
    /**
     * @param \Magento\Backend\Block\Template\Context 
     * @param Magento\Framework\View\Result\PageFactory
     */
    public function __construct
    (PageFactory $resultPageFactory,\Magento\Framework\App\Action\Context $context)
    {
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);          
    }

    /**
     * View blog homepage action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->addHandle('blog_post_print');
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }

}
