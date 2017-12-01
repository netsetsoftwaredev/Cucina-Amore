<?php
namespace WTC\Bsc\Model;

class Bsc extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('WTC\Bsc\Model\ResourceModel\Bsc');
    }
}
?>