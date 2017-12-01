<?php
namespace WTC\Bsc\Model\ResourceModel;

class Bsc extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('wtc_business_customers', 'id');
    }
}
?>