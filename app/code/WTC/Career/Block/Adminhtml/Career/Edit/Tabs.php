<?php
namespace WTC\Career\Block\Adminhtml\Career\Edit;

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
        $this->setId('career_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Career Information'));
    }
}