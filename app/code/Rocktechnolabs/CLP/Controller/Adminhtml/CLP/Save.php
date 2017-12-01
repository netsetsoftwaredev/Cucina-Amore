<?php
/**
 * @category Rocktechnolabs CLP
 * @package Rocktechnolabs_CLP
 * @copyright Copyright (c) 2017 Rocktechnolabs
 * @author Rocktechnolabs Team <support@rocktechnolabs.com>
 */
namespace Rocktechnolabs\CLP\Controller\Adminhtml\CLP;
use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;
use Magento\MediaStorage\Model\File\UploaderFactory;

/**
 * save Attach Action
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * Upload Factory
     *
     * @var Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $uploaderFactory;
    
    /**
     * Field Id
     *
     * @var $string='image'
     */
    protected $fileId = '1bimage';
    
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
    protected $_manageCLP;
    
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
        \Rocktechnolabs\CLP\Model\CLP $manageCLP)
    {
        $this->_jsHelper = $jsHelper;
        $this->uploaderFactory = $uploaderFactory;
        $this->directory_list = $directory_list;
        $this->_manageCLP = $manageCLP;
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
        /*echo "called";
        echo "<pre>";
        print_r($_REQUEST);
        exit;*/
        $resultRedirect = $this->resultRedirectFactory->create();
        if($data) 
        {
            $model=$this->_manageCLP;
            if(isset($data['1bimage']['delete'])) {
                $data['1bimage']="";
            } else {
                if(isset($_FILES['1bimage']['name']) && $_FILES['1bimage']['name'] != '') {
                    $imagename=$this->uploadImage();
                    $data['1bimage']="Rocktechnolabs".$imagename;
                } else{
                    if(isset($data['1bimage'])) {
                        $data['1bimage'] = $data['1bimage']['value'];
                    }
                } 
            }

            if(isset($data['2hwbimage1']['delete'])) {
                $data['2hwbimage1']="";
            } else {
                if(isset($_FILES['2hwbimage1']['name']) && $_FILES['2hwbimage1']['name'] != '') {
                    $imagename=$this->uploadFile("2hwbimage1");
                    $data['2hwbimage1']="Rocktechnolabs".$imagename;
                } else{
                    if(isset($data['2hwbimage1'])) {
                        $data['2hwbimage1'] = $data['2hwbimage1']['value'];
                    }
                } 
            }


            if(isset($data['2hwbimage2']['delete'])) {
                $data['2hwbimage2']="";
            } else {
                if(isset($_FILES['2hwbimage2']['name']) && $_FILES['2hwbimage2']['name'] != '') {
                    $imagename=$this->uploadFile("2hwbimage2");
                    $data['2hwbimage2']="Rocktechnolabs".$imagename;
                } else{
                    if(isset($data['2hwbimage2'])) {
                        $data['2hwbimage2'] = $data['2hwbimage2']['value'];
                    }
                } 
            }

            if(isset($data['2hwimage1']['delete'])) {
                $data['2hwimage1']="";
            } else {
                if(isset($_FILES['2hwimage1']['name']) && $_FILES['2hwimage1']['name'] != '') {
                    $imagename=$this->uploadFile("2hwimage1");
                    $data['2hwimage1']="Rocktechnolabs".$imagename;
                } else{
                    if(isset($data['2hwimage1'])) {
                        $data['2hwimage1'] = $data['2hwimage1']['value'];
                    }
                } 
            }

            if(isset($data['2hwimage2']['delete'])) {
                $data['2hwimage2']="";
            } else {
                if(isset($_FILES['2hwimage2']['name']) && $_FILES['2hwimage2']['name'] != '') {
                    $imagename=$this->uploadFile("2hwimage2");
                    $data['2hwimage2']="Rocktechnolabs".$imagename;
                } else{
                    if(isset($data['2hwimage2'])) {
                        $data['2hwimage2'] = $data['2hwimage2']['value'];
                    }
                } 
            }

            if(isset($data['2wtbimage1']['delete'])) {
                $data['2wtbimage1']="";
            } else {
                if(isset($_FILES['2wtbimage1']['name']) && $_FILES['2wtbimage1']['name'] != '') {
                    $imagename=$this->uploadFile("2wtbimage1");
                    $data['2wtbimage1']="Rocktechnolabs".$imagename;
                } else{
                    if(isset($data['2wtbimage1'])) {
                        $data['2wtbimage1'] = $data['2wtbimage1']['value'];
                    }
                } 
            }

            if(isset($data['2wtbimage2']['delete'])) {
                $data['2wtbimage2']="";
            } else {
                if(isset($_FILES['2wtbimage2']['name']) && $_FILES['2wtbimage2']['name'] != '') {
                    $imagename=$this->uploadFile("2wtbimage2");
                    $data['2wtbimage2']="Rocktechnolabs".$imagename;
                } else{
                    if(isset($data['2wtbimage2'])) {
                        $data['2wtbimage2'] = $data['2wtbimage2']['value'];
                    }
                } 
            }

            if(isset($data['2wtimage1']['delete'])) {
                $data['2wtimage1']="";
            } else {
                if(isset($_FILES['2wtimage1']['name']) && $_FILES['2wtimage1']['name'] != '') {
                    $imagename=$this->uploadFile("2wtimage1");
                    $data['2wtimage1']="Rocktechnolabs".$imagename;
                } else{
                    if(isset($data['2wtimage1'])) {
                        $data['2wtimage1'] = $data['2wtimage1']['value'];
                    }
                } 
            }

            if(isset($data['2wtimage2']['delete'])) {
                $data['2wtimage2']="";
            } else {
                if(isset($_FILES['2wtimage2']['name']) && $_FILES['2wtimage2']['name'] != '') {
                    $imagename=$this->uploadFile("2wtimage2");
                    $data['2wtimage2']="Rocktechnolabs".$imagename;
                } else{
                    if(isset($data['2wtimage2'])) {
                        $data['2wtimage2'] = $data['2wtimage2']['value'];
                    }
                } 
            }

            if(isset($data['2webimage1']['delete'])) {
                $data['2webimage1']="";
            } else {
                if(isset($_FILES['2webimage1']['name']) && $_FILES['2webimage1']['name'] != '') {
                    $imagename=$this->uploadFile("2webimage1");
                    $data['2webimage1']="Rocktechnolabs".$imagename;
                } else{
                    if(isset($data['2webimage1'])) {
                        $data['2webimage1'] = $data['2webimage1']['value'];
                    }
                } 
            }

            if(isset($data['2webimage2']['delete'])) {
                $data['2webimage2']="";
            } else {
                if(isset($_FILES['2webimage2']['name']) && $_FILES['2webimage2']['name'] != '') {
                    $imagename=$this->uploadFile("2webimage2");
                    $data['2webimage2']="Rocktechnolabs".$imagename;
                } else{
                    if(isset($data['2webimage2'])) {
                        $data['2webimage2'] = $data['2webimage2']['value'];
                    }
                } 
            }

            if(isset($data['2weimage1']['delete'])) {
                $data['2weimage1']="";
            } else {
                if(isset($_FILES['2weimage1']['name']) && $_FILES['2weimage1']['name'] != '') {
                    $imagename=$this->uploadFile("2weimage1");
                    $data['2weimage1']="Rocktechnolabs".$imagename;
                } else{
                    if(isset($data['2weimage1'])) {
                        $data['2weimage1'] = $data['2weimage1']['value'];
                    }
                } 
            }

            if(isset($data['2weimage2']['delete'])) {
                $data['2weimage2']="";
            } else {
                if(isset($_FILES['2weimage2']['name']) && $_FILES['2weimage2']['name'] != '') {
                    $imagename=$this->uploadFile("2weimage2");
                    $data['2weimage2']="Rocktechnolabs".$imagename;
                } else{
                    if(isset($data['2weimage2'])) {
                        $data['2weimage2'] = $data['2weimage2']['value'];
                    }
                } 
            }

            if(isset($data['3bimage2']['delete'])) {
                $data['3bimage2']="";
            } else {
                if(isset($_FILES['3bimage2']['name']) && $_FILES['3bimage2']['name'] != '') {
                    $imagename=$this->uploadFile("3bimage2");
                    $data['3bimage2']="Rocktechnolabs".$imagename;
                } else{
                    if(isset($data['3bimage2'])) {
                        $data['3bimage2'] = $data['3bimage2']['value'];
                    }
                } 
            }

            if(isset($data['3image31']['delete'])) {
                $data['3image31']="";
            } else {
                if(isset($_FILES['3image31']['name']) && $_FILES['3image31']['name'] != '') {
                    $imagename=$this->uploadFile("3image31");
                    $data['3image31']="Rocktechnolabs".$imagename;
                } else{
                    if(isset($data['3image31'])) {
                        $data['3image31'] = $data['3image31']['value'];
                    }
                } 
            }

            if(isset($data['3image32']['delete'])) {
                $data['3image32']="";
            } else {
                if(isset($_FILES['3image32']['name']) && $_FILES['3image32']['name'] != '') {
                    $imagename=$this->uploadFile("3image32");
                    $data['3image32']="Rocktechnolabs".$imagename;
                } else{
                    if(isset($data['3image32'])) {
                        $data['3image32'] = $data['3image32']['value'];
                    }
                } 
            }

            if(isset($data['4nutritionfact']['delete'])) {
                $data['4nutritionfact']="";
            } else {
                if(isset($_FILES['4nutritionfact']['name']) && $_FILES['4nutritionfact']['name'] != '') {
                    $imagename=$this->uploadFile("4nutritionfact");
                    $data['4nutritionfact']="Rocktechnolabs".$imagename;
                } else{
                    if(isset($data['4nutritionfact'])) {
                        $data['4nutritionfact'] = $data['4nutritionfact']['value'];
                    }
                } 
            }

            if(isset($data['4nutritionimage']['delete'])) {
                $data['4nutritionimage']="";
            } else {
                if(isset($_FILES['4nutritionimage']['name']) && $_FILES['4nutritionimage']['name'] != '') {
                    $imagename=$this->uploadFile("4nutritionimage");
                    $data['4nutritionimage']="Rocktechnolabs".$imagename;
                } else{
                    if(isset($data['4nutritionimage'])) {
                        $data['4nutritionimage'] = $data['4nutritionimage']['value'];
                    }
                } 
            }

             if(isset($data['5bimage']['delete'])) {
                $data['5bimage']="";
            } else {
                if(isset($_FILES['5bimage']['name']) && $_FILES['5bimage']['name'] != '') {
                    $imagename=$this->uploadFile("5bimage");
                    $data['5bimage']="Rocktechnolabs".$imagename;
                } else{
                    if(isset($data['5bimage'])) {
                        $data['5bimage'] = $data['5bimage']['value'];
                    }
                } 
            }


            if(isset($data['products']))
            {
                $productIds =str_replace("&", ",", $data['products']);
                $data['product_id']=$productIds;
            }
            if(isset($data["4nutritionicon"]))
            {
                $data["4nutritionicon"]=implode(",",$data["4nutritionicon"]);
            }
            if(isset($data["5flavor_id"]))
            {
                $data["5flavor_id"]=implode(",",$data["5flavor_id"]);
            }
            $model->setData($data);
            if(isset($data['clp_id'])) 
            {
                $model->setId($data['clp_id']);
            }
            
            try {
                $model->save();
                $this->saveProducts($model, $data);
                
                $this->messageManager->addSuccess(__('You saved this Record.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['clp_id' => $model->getId(), '_current' => true]);
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
            return $resultRedirect->setPath('*/*/edit', ['clp_id' => $this->getRequest()->getParam('clp_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
    
    /**
     * upload imege file
     *
     * @return $void
     */
    public function uploadImage()
    {
        $destinationPath = $this->getDestinationPath();
        
        try {
            $uploader = $this->uploaderFactory->create(['fileId' => '1bimage'])
                ->setAllowCreateFolders(true);
                $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(true);
                $result=$uploader->save($destinationPath);
                
              return $result['file'];  
                if (!$uploader->save($destinationPath)) {
                throw new LocalizedException(
                    __('File cannot be saved to path: $1', $destinationPath)
                );
                }
        } catch (\Exception $e) {
            $this->messageManager->addError(
                __($e->getMessage())
            );
        }
    }
    
    /**
     * upload imege file
     *
     * @return $void
     */
    public function uploadFile($name=null)
    {
        $destinationPath = $this->getDestinationFilePath();
        try {
            $uploader = $this->uploaderFactory->create(['fileId' =>$name])
                ->setAllowCreateFolders(true);
                $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(true);
                $result=$uploader->save($destinationPath);
                
              return $result['file'];  
                if (!$uploader->save($destinationPath)) {
                throw new LocalizedException(
                    __('File cannot be saved to path: $1', $destinationPath)
                );
                }
        } catch (\Exception $e) {
            $this->messageManager->addError(
                __($e->getMessage())
            );
        }
    }

    /**
     * Get Destination Path
     *
     * @return $directory_list
     */
    public function getDestinationFilePath()
    {
       return $this->directory_list->getPath('media')."/Rocktechnolabs/";
      
    }

    /**
     * Get Destination Path
     *
     * @return $directory_list
     */
    public function getDestinationPath()
    {
       return $this->directory_list->getPath('media')."/Rocktechnolabs/";
      
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

                $table = $this->_resources->getTableName(\Rocktechnolabs\CLP\Model\ResourceModel\CLP::TBL_ATT_PRODUCT);
                $insert = array_diff($newProducts, $oldProducts);
                $delete = array_diff($oldProducts, $newProducts);
                
                if ($delete) {
                    $where = ['clp_id = ?' => (int)$model->getId(), 'product_id IN (?)' => $delete];
                    $connection->delete($table, $where);
                }

                if ($insert) {
                    $data = [];
                    foreach ($insert as $product_id) {
                        $data[] = ['clp_id' => (int)$model->getId(), 'product_id' => (int)$product_id];
                    }
                    $connection->insertMultiple($table, $data);
                }
            } catch (Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Store.'));
            }
        }
    }    
}
