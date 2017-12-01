<?php
namespace WTC\Social\Model\ResourceModel;

class Social extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('wtc_social', 'id');
    }
}
?>