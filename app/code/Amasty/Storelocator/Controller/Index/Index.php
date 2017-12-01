<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_Storelocator
 */


namespace Amasty\Storelocator\Controller\Index;

use Magento\Framework\App\Action;

class Index  extends \Magento\Framework\App\Action\Action
{

    /**
     * Default customer account page
     *
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $ObjectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $title = $ObjectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue(
            'amlocator/locator/title',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $this->_view->getPage()->getConfig()->getTitle()->set($title);
        $this->_view->renderLayout();
    }
}
