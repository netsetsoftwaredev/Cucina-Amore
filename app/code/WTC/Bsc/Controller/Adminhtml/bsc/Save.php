<?php
namespace WTC\Bsc\Controller\Adminhtml\bsc;
use Magento\Backend\App\Action\Context;
class Save extends \Magento\Backend\App\Action
{
	/**
	* Recipient email config path
	*/
	const XML_PATH_EMAIL_RECIPIENT = 'contact/email/recipient_email';
	/**
	* @var \Magento\Framework\Mail\Template\TransportBuilder
	*/
	protected $_transportBuilder;

	/**
	* @var \Magento\Framework\Translate\Inline\StateInterface
	*/
	protected $inlineTranslation;

	/**
	* @var \Magento\Framework\App\Config\ScopeConfigInterface
	*/
	protected $scopeConfig;

	/**
	* @var \Magento\Store\Model\StoreManagerInterface
	*/
	protected $storeManager; 
	/**
	* @var \Magento\Framework\Escaper
	*/
	protected $_escaper;
	/**
	* @param \Magento\Framework\App\Action\Context $context
	* @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
	* @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
	* @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
	* @param \Magento\Store\Model\StoreManagerInterface $storeManager
	*/
	
	public function __construct(
		//\Magento\Framework\App\Action\Context $context,
		//\Magento\Backend\App\Action\Context $context,
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
		\Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\Escaper $escaper
	){
		parent::__construct($context);
		$this->_transportBuilder = $transportBuilder;
		$this->inlineTranslation = $inlineTranslation;
		$this->scopeConfig = $scopeConfig;
		$this->storeManager = $storeManager;
		$this->_escaper = $escaper;
	}

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        
        
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $model = $this->_objectManager->create('WTC\Bsc\Model\Bsc');

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
                $model->setCreatedAt(date('Y-m-d H:i:s'));
            }
			
            $model->setData($data);

            try {
                $model->save();
				$this->sendEmail($data);
                $this->messageManager->addSuccess(__('The Bsc has been saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
				
                $this->messageManager->addException($e, __($e->getMessage()));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
	
	public function sendEmail($data){
		$this->inlineTranslation->suspend();
		try {
			$postObject = new \Magento\Framework\DataObject();
			$postObject->setData($data);

			$error = false;

			$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE; 
			
			$sender = [
				'email' => $this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT, $storeScope),
				'name' => "Cucina & Amore",
			];

			
			$transport = $this->_transportBuilder
				->setTemplateIdentifier('send_email_email_template') // this code we have mentioned in the email_templates.xml
				->setTemplateOptions(
					[
					'area' => \Magento\Framework\App\Area::AREA_FRONTEND, // this is using frontend area to get the template file
					'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
					]
				)
				->setTemplateVars(['data' => $postObject])
				->setFrom($sender)
				->addTo($data['email'])
				->getTransport();

			$transport->sendMessage(); ;
			$this->inlineTranslation->resume();
			$this->messageManager->addSuccess(
				__('Thanks for contacting us with your comments and questions. We\'ll respond to you very soon.')
			);
			return;
		}catch(\Exception $e) {
			$this->inlineTranslation->resume();
			$this->messageManager->addError(
				__('We can\'t process your request right now. Sorry, that\'s all we know.'.$e->getMessage())
			);
		}
	}
}