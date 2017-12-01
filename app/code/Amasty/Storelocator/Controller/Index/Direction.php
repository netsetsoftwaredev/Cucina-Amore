<?php

namespace Amasty\Storelocator\Controller\Index;

class Direction extends \Magento\Framework\App\Action\Action
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
		$data['lat'] = $this->getRequest()->getParam('lat');
		$data['lng'] = $this->getRequest()->getParam('lng');
		$data['id'] = $this->getRequest()->getParam('id');
		$data['email'] = $this->getRequest()->getParam('email');
		$this->sendEmail($data);
    }
	
	public function sendEmail($data){
		$this->inlineTranslation->suspend();
		try {
			$id = $data['id'];
			$om = \Magento\Framework\App\ObjectManager::getInstance();
			$helper = $om->get('Amasty\Storelocator\Helper\Detail');
			$hdata = $helper->getStoreInfo($id);
			/*  $storeInfo = "
				"."<b>".$hdata["name"]."</b><br/>"."
				".$hdata["address"]."<br/>"."
				".$hdata["city"]."<br/>"."
				".$hdata["zip"]."<br/>"."
				".$hdata["state"]."<br/>"."
				".$hdata["country"]."<br/>"."
				".$hdata["phone"]."<br/>"."
				".$hdata["email"]."<br/>"."
				".$hdata["website"]."<br/>"."
				".$hdata["description"]."<br/>"."
			"; */
			$data['name'] = $hdata['name'];
			$data['address'] = $hdata['address'];
			$data['city'] = $hdata['city'];
			$data['zip'] = $hdata['zip'];
			$data['state'] = $hdata['state'];
			$data['country'] = $hdata['country'];
			$data['phone'] = $hdata['phone'];
			$data['hemail'] = $hdata['email'];
			$data['website'] = $hdata['website'];
			$data['description'] = $hdata['description'];
			
			//$data['info'] = $storeInfo;
			
			$lat = $data['lat'];
			$lng = $data['lng'];
			$data['url'] = $this->storeManager->getStore()->getBaseUrl()."amlocator/index/detail/id/$id/lat/$lat/lng/$lng";
			$postObject = new \Magento\Framework\DataObject();
			$postObject->setData($data);
			
			
			$error = false;

			$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE; 
			
			$sender = [
				'email' => $this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT, $storeScope),
				'name' => "Cucina & Amore"
			];
			
			try{
				$transport = $this->_transportBuilder
				->setTemplateIdentifier('send_email_template_direction') // this code we have mentioned in the email_templates.xml
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
				echo "Thank you. Please check your email for more information.";
			}catch(exception $ex){
				echo $ex->getMessage();
			}
		}catch(\Exception $e) {
			//$this->inlineTranslation->resume();
			echo 'We can\'t process your request right now. Sorry, that\'s all we know.'.$e->getMessage();
		}
		exit(0);
	}
}