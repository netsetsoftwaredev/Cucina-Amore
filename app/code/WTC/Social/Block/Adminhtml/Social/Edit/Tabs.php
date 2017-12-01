<?php
namespace WTC\Social\Block\Adminhtml\Social\Edit;

/**
 * Admin page left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('social_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Social Information'));
    }
}