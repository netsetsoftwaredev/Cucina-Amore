<?php
namespace WTC\Instagram\Model;

class Instagram extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('WTC\Instagram\Model\ResourceModel\Instagram');
    }
}
?>