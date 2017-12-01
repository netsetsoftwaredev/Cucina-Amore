<?php

namespace WTC\Bsc\Controller\Enquiry;

class Send extends \Magento\Framework\App\Action\Action
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
	\Magento\Framework\App\Action\Context $context,
	\Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
	\Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
	\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
	\Magento\Store\Model\StoreManagerInterface $storeManager,
	\Magento\Framework\Escaper $escaper
	) {
	parent::__construct($context);
	$this->_transportBuilder = $transportBuilder;
	$this->inlineTranslation = $inlineTranslation;
	$this->scopeConfig = $scopeConfig;
	$this->storeManager = $storeManager;
	$this->_escaper = $escaper;
	}
	
    public function execute()
    {
		$model = $this->_objectManager->create('WTC\Bsc\Model\Bsc');
		$data = $this->getRequest()->getPostValue();
		$email = $data['email'];
		$objectManager = $this->_objectManager;
		$customerSession = $objectManager->get('Magento\Customer\Model\Session');
		$urlInterface = $objectManager->get('\Magento\Framework\UrlInterface');
		
		//Set Model Data
		$model->setData($data);
		$password = $this->generateRandomString();
		$model->setPassword($password);
		try{
			$model->save();
			$this->sendEmail($data,$password);
		}catch(exception $e){
			$this->messageManager->addError($e->getMessage());
		}
		
		$resultRedirect = $this->resultRedirectFactory->create();
		return $resultRedirect->setPath('*/*/');
    }
	
	public function sendEmail($data,$password){
		$this->inlineTranslation->suspend();
		try {
			$postObject = new \Magento\Framework\DataObject();
			$postObject->setData($data);
			$postObject->setPassword($password);
			$error = false;

			$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE; 
			
			$sender = [
				'email' => $this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT, $storeScope),
				'name' => "Cucina & Amore"
			];

			
			$transport = $this->_transportBuilder
				->setTemplateIdentifier('send_email_template_enquiry') // this code we have mentioned in the email_templates.xml
				->setTemplateOptions(
					[
					'area' => \Magento\Framework\App\Area::AREA_FRONTEND, // this is using frontend area to get the template file
					'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
					]
				)
				->setTemplateVars(['data' => $postObject])
				->setFrom($sender)
				//->addTo($this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT, $storeScope))
				->addTo($data['email'])
				->getTransport();

			$transport->sendMessage(); ;
			$this->inlineTranslation->resume();
			$this->messageManager->addSuccess(
				__('Thanks for contacting us. We\'ll respond to you very soon.')
			);
			return;
		}catch(\Exception $e) {
			$this->inlineTranslation->resume();
			$this->messageManager->addError(
				__('We can\'t process your request right now. Sorry, that\'s all we know.'.$e->getMessage())
			);
		}
	}
	
	public function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}