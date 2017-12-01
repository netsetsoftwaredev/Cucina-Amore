<?php

namespace WTC\Career\Block\Index;


class Careerlist extends \Magento\Framework\View\Element\Template {

    public function __construct(\Magento\Catalog\Block\Product\Context $context, array $data = []) {

        parent::__construct($context, $data);

    }


    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
	
	public function getJobList()
    {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		return $objectManager->get('Magento\Framework\Registry')->registry('joblist');
    }
	
	public function getJobCategory(){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		return $objectManager->get('Magento\Framework\Registry')->registry('job_category');
		
	}

}