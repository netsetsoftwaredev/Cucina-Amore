<?php
namespace WTC\Slimport\Controller\Adminhtml\Index;
ini_set('display_errors',1);
use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magento\Backend\App\Action
{
	/**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * File system
     *
     * @var \Magento\Framework\Filesystem
     */
    protected $_filesystem;

    /**
     * File Uploader factory
     *
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $_fileUploaderFactory;

    /**
     * @var \Magento\Framework\Filesystem\Io\File
     */
    protected $_ioFile;

    /**
     * @var \Amasty\Base\Model\Serializer
     */
    protected $serializer;
	
	protected $fileSystem;
 
    protected $uploaderFactory;
 
    protected $allowedExtensions = ['csv']; // to allow file upload types 
 
    protected $fileId = 'file'; // name of the input file box  
	
	/**
     * Initialize Group Controller
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Amasty\Base\Model\Serializer $serializer,
        \Magento\Framework\Filesystem\Io\File $ioFile
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->_filesystem = $filesystem;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->serializer = $serializer;
        $this->_ioFile = $ioFile;
    }
	
    public function execute()
    {
		/** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
		if($this->getRequest()->getPostValue()){
			$destinationPath = $this->getDestinationPath();
			$uploaderFactory = $this->_objectManager->create('Magento\MediaStorage\Model\File\UploaderFactory');
			
			try {
				$uploader = $uploaderFactory->create(['fileId' => $this->fileId])
					->setAllowCreateFolders(true)
					->setAllowedExtensions($this->allowedExtensions)
					->addValidateCallback('validate', $this, 'validateFile');
				if (!($result = $uploader->save($destinationPath))) {
					throw new LocalizedException(
						__('File cannot be saved to path: $1', $destinationPath)
					);
				}
				
				$name = $result['name'];
				$filePath = $destinationPath.$name;
				if(file_exists($filePath)){
					$data = $this->csv_to_array($filePath);
					$this->saveStore($data);
				}
				
			} catch (\Exception $e) {
				echo $e->getMessage();die;
				$this->messageManager->addError(
					__()
				);
			}
		}
		return $resultRedirect->setPath('*/*/');
    }
	
	public function saveStore($data){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
		foreach($data as $store){
			$stores = explode(',',$store['stores']);
			//$store['image'] = "pub/media/amasty/amlocator/".$store['store_img'];
			$rule = array();
			$rule['1'] =array
					(
						'type' => "\Magento\SalesRule\Model\Rule\Condition\Product\Combine",
						'aggregator' => "all",
						'value' => 1,
						'new_chld' => ""
					);
			if($store['category_ids'] != ""){
				$rule['1--1'] =array
						(
							'type' => "\Magento\SalesRule\Model\Rule\Condition\Product",
							'attribute' => "category_ids",
							'operator' => "==",
							'value' => $store['category_ids']
						);
			}
			if($store['skus'] != ""){
				$rule['1--1'] =array
						(
							'type' => "\Magento\SalesRule\Model\Rule\Condition\Product",
							'attribute' => "sku",
							'operator' => "==",
							'value' => $store['skus']
						);
			}
			
			$schedule = array();
			// Monday Timing
			$mon_start = date("H:i", strtotime($store['mon_start']));
			$mon_start = explode(":",$mon_start);
			$mon_end = date("H:i", strtotime($store['mon_end']));
			$mon_end = explode(":",$mon_end);
			$schedule[1] = array(
						'from' => $mon_start,
						'to'   => $mon_end
					);
			
			// Tuesday Timing
			$tue_start = date("H:i", strtotime($store['tue_start']));
			$tue_start = explode(":",$tue_start);
			$tue_end = date("H:i", strtotime($store['tue_end']));
			$tue_end = explode(":",$tue_end);
			$schedule[2] = array(
						'from' => $tue_start,
						'to'   => $tue_end
					);
					
			// WEdnesday timing
			$wed_start = date("H:i", strtotime($store['wed_start']));
			$wed_start = explode(":",$wed_start);
			$wed_end = date("H:i", strtotime($store['wed_end']));
			$wed_end = explode(":",$wed_end);
			$schedule[3] = array(
						'from' => $wed_start,
						'to'   => $wed_end
					);
					
			// Thursday timing
			$thu_start = date("H:i", strtotime($store['thu_start']));
			$thu_start = explode(":",$thu_start);
			$thu_end = date("H:i", strtotime($store['thu_end']));
			$thu_end = explode(":",$thu_end);
			$schedule[4] = array(
						'from' => $thu_start,
						'to'   => $thu_end
					);
			
					
			// Friday timing
			$fri_start = date("H:i", strtotime($store['fri_start']));
			$fri_start = explode(":",$fri_start);
			$fri_end = date("H:i", strtotime($store['fri_end']));
			$fri_end = explode(":",$fri_end);
			$schedule[5] = array(
						'from' => $fri_start,
						'to'   => $fri_end
					);
					
			// saturday timing
			$sat_start = date("H:i", strtotime($store['sat_start']));
			$sat_start = explode(":",$sat_start);
			$sat_end = date("H:i", strtotime($store['sat_end']));
			$sat_end = explode(":",$sat_end);
			$schedule[6] = array(
						'from' => $sat_start,
						'to'   => $sat_end
					);
					
			// sunday timing
			$sun_start = date("H:i", strtotime($store['sun_start']));
			$sun_start = explode(":",$sun_start);
			$sun_end = date("H:i", strtotime($store['sun_end']));
			$sun_end = explode(":",$sun_end);
			$schedule[7] = array(
						'from' => $sun_start,
						'to'   => $sun_end
					);
			$store['rule']['actions'] = $rule;
			$store['schedule'] = $schedule;
			//echo '<pre>';print_r($store);
			//die('test');
			$this->saveRecord($store);
		}
		$this->messageManager->addSuccess(__('You saved the item.'));
		return;
	}
    
    public function validateFile($filePath)
    {
        // @todo
        // your custom validation code here
    }
 
    public function getDestinationPath()
    {
		$fileSystem = $this->_objectManager->create('Magento\Framework\Filesystem');
        return $fileSystem
            ->getDirectoryWrite(DirectoryList::TMP)
            ->getAbsolutePath('/');
    }
	
	public function csv_to_array($filename='', $delimiter=',')
	{
		if(!file_exists($filename) || !is_readable($filename)){
			return FALSE;
		}
		$header = NULL;
		$data = array();
		if (($handle = fopen($filename, 'r')) !== FALSE)
		{
			while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
			{
				if(!$header)
					$header = $row;
				else
					$data[] = array_combine($header, $row);
			}
			fclose($handle);
		}
		return $data;
	}
	
	 public function saveRecord($data)
    {
            try {
                $model = $this->_objectManager->create('Amasty\Storelocator\Model\Location');
                $inputFilter = new \Zend_Filter_Input(
                    [],
                    [],
                    $data
                );
                $data = $inputFilter->getUnescaped();
                /* $id = $this->getRequest()->getParam('id');
                if ($id) {
                    $model->load($id);
                    if ($id != $model->getId()) {
                        throw new \Magento\Framework\Exception\LocalizedException(__('The wrong item is specified.'));
                    }
                } */
                if (isset($data['rule']['actions'])) {
                    $data['actions'] = $data['rule']['actions'];
                }
                if (isset($data['stores']) && !$data['stores']) {
                    $data['stores'] = ',1,';
                }
                if (isset($data['stores']) && is_array($data['stores'])) {
                    $data['stores'] = ',' . implode(',', $data['stores']) . ',';
                }

                if (isset($data['state_id'])) {
                    $data['state'] = $data['state_id'];
                }

                $data['schedule'] = $this->serializer->serialize($data['schedule']);

                unset($data['rule']);

                $model->addData($data);
                $model->loadPost($data); // rules

                $data['actions_serialize'] = $this->serializer->serialize($model->getActions()->asArray());

                //$this->_prepareForSave($model);

                $session = $this->_objectManager->get('Magento\Backend\Model\Session');
                $session->setPageData($model->getData());
                $model->save();
				//echo $model->getId();
                
                $session->setPageData(false);
               // return;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
			//	echo $e->getmessage();die;
               // return;
            } catch (\Exception $e) {
				$this->messageManager->addError($e->getMessage());
              // echo $e->getmessage();die;
            }
    }

    /* protected function _prepareForSave($model)
    {
        //upload images
        $data = $this->getRequest()->getPost();
        $path = $this->_filesystem->getDirectoryRead(
            DirectoryList::MEDIA
        )->getAbsolutePath(
            'amasty/amlocator/'
        );

        $imagesTypes = array('store', 'marker');
        foreach ($imagesTypes as $type) {
            $field = $type . '_img';

            $files = $this->getRequest()->getFiles();

            $isRemove = array_key_exists('remove_' . $field, $data);
            $fileName = $this->getRequest()->getFiles($field)['name'];
            $hasNew   = !empty($fileName);

            try {
                // remove the old file
                if ($isRemove || $hasNew) {
                    $oldName = isset($data['old_' . $field]) ? $data['old_' . $field] : '';
                    if ($oldName) {
                        $this->_ioFile->rm($path . $oldName);
                        $model->setData($field, '');
                    }
                }

                // upload a new if any
                if (!$isRemove && $hasNew) {
                    //find the first available name
                    $newName = preg_replace('/[^a-zA-Z0-9_\-\.]/', '', $files[$field]['name']);
                    if (substr($newName, 0, 1) == '.') {
                        $newName = 'label' . $newName;
                    }
                    $uploader = $this->_fileUploaderFactory->create(['fileId' => $field]);
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                    $uploader->setAllowRenameFiles(true);
                    $uploader->save($path, $newName);

                    $model->setData($field, $newName);
                }
            } catch (\Exception $e) {
                if ($e->getCode() != \Magento\MediaStorage\Model\File\Uploader::TMP_NAME_EMPTY) {
                    $this->_logger->critical($e);
                }
            }
        }

        return true;
    } */
	
}