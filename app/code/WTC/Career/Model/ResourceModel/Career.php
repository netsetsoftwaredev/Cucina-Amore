<?php
namespace WTC\Career\Model\ResourceModel;

class Career extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('wtc_career', 'id');
    }
}
?>