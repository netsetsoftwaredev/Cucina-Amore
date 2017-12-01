<?php

namespace WTC\Bsc\Model\ResourceModel\Bsc;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('WTC\Bsc\Model\Bsc', 'WTC\Bsc\Model\ResourceModel\Bsc');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>