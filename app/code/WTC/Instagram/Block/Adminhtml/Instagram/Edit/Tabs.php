<?php
namespace WTC\Instagram\Block\Adminhtml\Instagram\Edit;

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
        $this->setId('instagram_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Instagram Information'));
    }
}