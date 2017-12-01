<?php
namespace WTC\Career\Model;

class Career extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('WTC\Career\Model\ResourceModel\Career');
    }
}
?>