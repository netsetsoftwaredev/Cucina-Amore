<?php
/**
 * @attach Rocktechnolabs CLP
 * @package Rocktechnolabs_CLP
 * @copyright Copyright (c) 2017 Rocktechnolabs
 * @author Rocktechnolabs Team <support@rocktechnolabs.com>
 */

namespace Rocktechnolabs\CLP\Controller\Adminhtml\Flavor;
use Magento\Backend\App\Action\Context;
use Rocktechnolabs\CLP\Model\Flavor;
/** 
 * Delete class
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var Contact $attachModel
     */
    protected $_attachModel;

    /**
     * @param Context $context
     * @param attach Model $attach_model
     */
    public function __construct(Context $context,Flavor $attachModel)
    {
        $this->_attachModel = $attachModel;
        parent::__construct($context);
    }
   
    /**
     * Delete Action
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('flavor_id');
        try {
                $image = $this->_attachModel->load($id);
                $image->delete();
                $this->messageManager->addSuccess(
                    __('Delete successfully !')
                );
        } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
    }
}

