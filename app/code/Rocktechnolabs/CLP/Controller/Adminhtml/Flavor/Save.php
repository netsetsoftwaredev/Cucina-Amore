<?php
/**
 * @category Rocktechnolabs CLP
 * @package Rocktechnolabs_CLP
 * @copyright Copyright (c) 2017 Rocktechnolabs
 * @author Rocktechnolabs Team <support@rocktechnolabs.com>
 */
namespace Rocktechnolabs\CLP\Controller\Adminhtml\Flavor;
use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;
use Magento\MediaStorage\Model\File\UploaderFactory;

/**
 * save Attach Action
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * Js Helper
     *
     * @var \Magento\Backend\Helper\Js
     */
    protected $_jsHelper;

    /**
     * Managet Store
     *
     * @var \Rocktechnolabs\CLP\Model\CLP
     */
    protected $_manageFlavor;
    
    /**
     * @param \Magento\Backend\Block\Template\Context 
     * @param \Magento\Backend\Helper\Js
     * @param \Magento\MediaStorage\Model\File\UploaderFactory
     * @param \Magento\Framework\App\Filesystem\DirectoryList
     * @param \Rocktechnolabs\CLP\Model\CLP
     */
    public function __construct(Action\Context $context,
        \Magento\Backend\Helper\Js $jsHelper,
        UploaderFactory $uploaderFactory,
        \Magento\Framework\App\Filesystem\DirectoryList $directory_list,
        \Rocktechnolabs\CLP\Model\Flavor $manageFlavor)
    {
        $this->_jsHelper = $jsHelper;
        $this->uploaderFactory = $uploaderFactory;
        $this->directory_list = $directory_list;
        $this->_manageFlavor = $manageFlavor;
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
     * perform execute method for save Action
     *
     * @return $resultRedirect
     */
    public function execute()
    {
        $data =$this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if($data) 
        {
            $model=$this->_manageFlavor;
            if(isset($data['products']))
            {
                $productIds =str_replace("&", ",", $data['products']);
                $data['product_id']=$productIds;
            }
            
            if(isset($data['flavor_id'])) 
            {
                $model->setId($data['flavor_id']);
            }
            $model->setData($data);
            try {
                $model->save();
                $this->saveProducts($model, $data);
                
                $this->messageManager->addSuccess(__('You saved this Record.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['flavor_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the record.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['flavor_id' => $this->getRequest()->getParam('flavor_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
    
    
    /**
     * save product for CLP
     *
     * @return $void
     */
    public function saveProducts($model, $post)
    {
        if (isset($post['products'])) {
            $productIds = $this->_jsHelper->decodeGridSerializedInput($post['products']);
            try {
                
                $oldProducts = (array) $model->getProducts($model);
                $newProducts = (array) $productIds;
                
                $this->_resources = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
                $connection = $this->_resources->getConnection();
                $table = $this->_resources->getTableName(\Rocktechnolabs\CLP\Model\ResourceModel\Flavor::TBL_ATT_PRODUCT);
                $insert = array_diff($newProducts, $oldProducts);
                $delete = array_diff($oldProducts, $newProducts);
                
                if ($delete) {
                    $where = ['flavor_id = ?' => (int)$model->getId(), 'product_id IN (?)' => $delete];
                    $connection->delete($table, $where);
                }

                if ($insert) {
                    $data = [];
                    foreach ($insert as $product_id) {
                        $data[] = ['flavor_id' => (int)$model->getId(), 'product_id' => (int)$product_id];
                    }
                    $connection->insertMultiple($table, $data);
                }
            } catch (Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Store.'));
            }
        }
    }    
}
