<?php
/**
 * @category Rocktechnolabs CLP
 * @package Rocktechnolabs_CLP
 * @copyright Copyright (c) 2017 Rocktechnolabs
 * @author Rocktechnolabs Team <support@rocktechnolabs.com>
 */
namespace Rocktechnolabs\CLP\Controller\Adminhtml\Flavor;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * index Action for CLP
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * result page Factory
     *
     * @var Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context 
     * @param Magento\Framework\View\Result\PageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) 
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Rocktechnolabs_CLP::Flavor');
    }
    
    /**
     * Execute method for CLP index action
     *
     * @return $resultPage
     */ 
    public function execute()
    {
        /**
         * render The admin grid page
         */      
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Rocktechnolabs_CLP::clp');
        $resultPage->addBreadcrumb(__('CLP Flavor'), __('CLP Flavor'));
        $resultPage->addBreadcrumb(__('Manage Flavor'), __('Manage Flavor'));
        $resultPage->getConfig()->getTitle()->prepend(__('CLP'));
        return $resultPage;
    }
}
