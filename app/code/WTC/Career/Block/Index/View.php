<?php
namespace WTC\Career\Block\Index;

use Magento\Framework\View\Element\Template;

class View extends Template
{
    protected $_coreRegistry;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        array $data = []
    ) {
		parent::__construct($context, $data);
    }
	
	

    public function getJob()
    {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		return $objectManager->get('Magento\Framework\Registry')->registry('job');
    }
}