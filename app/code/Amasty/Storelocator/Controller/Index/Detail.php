<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Storelocator
 */

/**
 * Copyright © 2015 Amasty. All rights reserved.
 */

namespace Amasty\Storelocator\Controller\Index;
use Magento\Framework\App\Action;

class Detail  extends \Magento\Framework\App\Action\Action
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
        $this->_view->renderLayout();
    }
}