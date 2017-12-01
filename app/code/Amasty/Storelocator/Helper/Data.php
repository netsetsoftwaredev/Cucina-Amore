<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_Storelocator
 */


namespace Amasty\Storelocator\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var int
     */
    protected $_statusId = null;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Helper\Context $context
    ){
        parent::__construct($context);
        $this->_storeManager = $storeManager;
    }

    /**
     * @param $name
     *
     * @return string
     */
    public function getImageUrl($name)
    {
		
        $path = $this->_storeManager->getStore()->getBaseUrl( \Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
		return $path . 'wysiwyg/storelocator/'. $name;
		/* $absPath = getcwd() . '/pub/media/amasty/amlocator/'. $name;
		if(!file_exists($absPath)){
			
		}else{
			return $path . 'amasty/amlocator/'. $name;
		} */
        
    }

    public function validateLocation($location, $product)
    {
        $location->setProduct($product);
        $valid = $location->getActions()->validate($location);
        if ($valid) {
            return true;
        }

        return false;
    }

    public function getDaysNames()
    {
        return [
            '1' => __('Monday'),
            '2' => __('Tuesday'),
            '3' => __('Wednesday'),
            '4' => __('Thursday'),
            '5' => __('Friday'),
            '6' => __('Saturday'),
            '7' => __('Sunday'),
        ];
    }

}