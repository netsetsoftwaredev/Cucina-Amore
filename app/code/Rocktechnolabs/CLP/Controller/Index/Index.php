<?php
/**
 * @category Mageants StoreLocator
 * @package Mageants_StoreLocator
 * @copyright Copyright (c) 2017 Mageants
 * @author Mageants Team <support@Mageants.com>
 */
namespace Rocktechnolabs\CLP\Controller\Index;
use Magento\Framework\View\Result\PageFactory;

/**
 * Index for Store frontend
 */
class Index extends \Magento\Framework\App\Action\Action
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
	 * perform execute method for Index
	 *
	 * @return $void
	 */
    public function execute()
    {
    	if($this->getRequest()->getPostValue()):
            $resultPage = $this->_resultPageFactory->create();
            $block = $resultPage->getLayout()
					->createBlock('Rocktechnolabs\CLP\Block\Clp')
					->setTemplate('Rocktechnolabs_CLP::clp.phtml')
					->toHtml();
            echo $block;
            return;
        endif;
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
