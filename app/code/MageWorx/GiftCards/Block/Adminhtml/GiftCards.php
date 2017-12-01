<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Block\Adminhtml;

class GiftCards extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml';
        $this->_blockGroup = 'MageWorx_GiftCards';
        $this->_headerText = __('MageWorx Giftcards');
        $this->_addButtonLabel = __('Add New Giftcard');
        parent::_construct();
    }

    protected function _prepareLayout()
    {
        $this->setChild(
            'grid',
            $this->getLayout()->createBlock(
                'MageWorx\GiftCards\Block\Adminhtml\GiftCards\Grid',
                'mageworx.giftcards.grid'
            )
        );
        
        return parent::_prepareLayout();
    }

    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }
}
