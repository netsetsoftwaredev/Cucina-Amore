<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Block\Adminhtml\Generate;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_blockGroup = 'MageWorx_GiftCards';
        $this->_controller = 'adminhtml_generate';
        parent::_construct();

        $this->buttonList->update('save', 'label', __('Generate Gift Cards'));

        $this->removeButton('add');
        $this->removeButton('reset');
        $this->removeButton('back');
    }
}
