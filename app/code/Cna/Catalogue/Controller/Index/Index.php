<?php
namespace Cna\Catalogue\Controller\Index;
class Index extends \Magento\Framework\App\Action\Action
{
    /**
    * Sales email sender name
    */
    const XML_PATH_NAME_SALES = 'trans_email/ident_general/name';
    /**
    * Sales email 
    */
    const XML_PATH_EMAIL_SALES = 'trans_email/ident_general/email';
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

    protected $subscriberFactory;
    protected $resultPageFactory;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory,
        \Magento\Framework\Escaper $escaper
    )
    {
        $this->resultPageFactory = $resultPageFactory;        
        $this->_transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->_escaper = $escaper;
         $this->subscriberFactory= $subscriberFactory;
        parent::__construct($context);
    }
    
    public function execute()
    {	
    	$post = $this->getRequest()->getPostValue();

        if (!$post) {
        $this->_redirect('*/*/');
        return;
        }

        $this->inlineTranslation->suspend();
        try {
        $postObject = new \Magento\Framework\DataObject();
        $catalogueData = array('pdf'=>$this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)."catalogue/Cucina&Amore_Kitchen&Love_2018.pdf", 'name'=>$post['name']);
        $postObject->setData($catalogueData);

        $error = false;
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE; 
       
        $sender = [
        'name' => $this->_escaper->escapeHtml($this->scopeConfig->getValue(self::XML_PATH_NAME_SALES, $storeScope)),
        'email' => $this->_escaper->escapeHtml($this->scopeConfig->getValue(self::XML_PATH_EMAIL_SALES, $storeScope)),
        ];

        
        $transport = $this->_transportBuilder
        ->setTemplateIdentifier('catalog_email_template') // this code we have mentioned in the email_templates.xml
        ->setTemplateOptions(
        [
        'area' => \Magento\Framework\App\Area::AREA_FRONTEND, // this is using frontend area to get the template file
        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
        ]
        )
        ->setTemplateVars(['data' => $postObject])
        ->setFrom($sender)
        ->addTo($post['email'])
        ->getTransport();

        $transport->sendMessage(); ;
        $this->inlineTranslation->resume();
        $this->messageManager->addSuccess(
        __('Thanks for contacting us with your comments and questions. We\'ll respond to you very soon.')
        );
        //$this->_redirect('*/*/');
        //return;
        /*echo "success";
        exit;*/
        } catch (\Exception $e) {
        $this->inlineTranslation->resume();
        $this->messageManager->addError(
        __('We can\'t process your request right now. Sorry, that\'s all we know.'.$e->getMessage())
        );
         }
        
        if(array_key_exists('subscribe', $post)){
            $subscribed = $this->subscriberFactory->create()->loadByEmail($post['email']);
            if(!$subscribed->isSubscribed()){
                $this->subscriberFactory->create()->subscribe($post['email']);    
            }    
        }
        exit;
    	return $this->resultPageFactory->create();  
    }
}
