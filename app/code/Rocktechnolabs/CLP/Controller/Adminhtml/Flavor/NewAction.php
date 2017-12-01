<?php
/**
 * @category Rocktechnolabs CLP
 * @package Rocktechnolabs_CLP
 * @copyright Copyright (c) 2017 Rocktechnolabs
 * @author Rocktechnolabs Team <support@rocktechnolabs.com>
 */
namespace Rocktechnolabs\CLP\Controller\Adminhtml\Flavor;

/**
 * NewAction for Flavor
 */
class NewAction extends \Magento\Backend\App\Action
{
    /**
     * CLP result forward factory
     *
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**edit
     * @param \Magento\Backend\Block\Template\Context 
     * @param \Magento\Backend\Model\View\Result\ForwardFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) 
    {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Rocktechnolabs_CLP::save');
    }
    
    /**
     * perform execute method for newAction
     *
     * @return $resultRedirect
     */
    public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
