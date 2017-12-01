<?php
namespace WTC\Bsc\Block\Adminhtml\Bsc\Edit;

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
        $this->setId('bsc_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Bsc Information'));
    }
}