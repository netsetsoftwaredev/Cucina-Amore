<?php
/**
 * @category Rocktechnolabs CLP
 * @package Rocktechnolabs_CLP
 * @copyright Copyright (c) 2017 Rocktechnolabs
 * @author Rocktechnolabs Team <support@rocktechnolabs.com>
 */
namespace Rocktechnolabs\CLP\Controller\Adminhtml\CLP;

use Magento\Backend\App\Action;
/**
 * store edit Action
 */
class Edit extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * result page factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * session model
     *
     * @var \Magento\Backend\Model\Session
     */
    protected $_session;

    /**
     * product attachment
     * 
     * @var \Rocktechnolabs\CLP\Model\CLP
     */
    protected $_productCLP;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Rocktechnolabs\CLP\Model\CLP $productCLP
     * @param \Magento\Backend\Model\Session $session
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \Rocktechnolabs\CLP\Model\CLP $productCLP
    )
    {
        $this->_session=$context->getSession();
        $this->_productCLP=$productCLP;
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return true;
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Rocktechnolabs_CLP::clp')
            ->addBreadcrumb(__('Lists'), __('Lists'))
            ->addBreadcrumb(__('Manage Info'), __('Manage Info'));
        return $resultPage;
    }

    /**
     * Edit Store
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('clp_id');
        $model = $this->_productCLP;

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This info no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        // 3. Set entered data if was error when we do save
        $data = $this->_session->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        $this->_coreRegistry->register('clp_data', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit CLP') : __('New CLP'),
            $id ? __('Edit CLP') : __('New CLP')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('CLP'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? __('Edit CLP') : __('New CLP'));
        return $resultPage;
    }
}
