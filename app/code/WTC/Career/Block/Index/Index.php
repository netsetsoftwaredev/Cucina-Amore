<?php

namespace WTC\Career\Block\Index;


class Index extends \Magento\Framework\View\Element\Template {

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
		return $objectManager->get('\WTC\Career\Helper\Data')->getJoblist();
    }
	
	public function getJobCategories(){
		$data_array=array(); 
		$data_array['Corporate']='Corporate';
		$data_array['Marketing']='Marketing';
		$data_array['R&D']='R&D';
		$data_array['Sales']='Sales';
		$data_array['Warehouse']='Warehouse';
		$data_array['Transportation']='Transportation';
		return($data_array);
	}

}