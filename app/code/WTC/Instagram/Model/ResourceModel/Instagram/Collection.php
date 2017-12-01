<?php

namespace WTC\Instagram\Model\ResourceModel\Instagram;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('WTC\Instagram\Model\Instagram', 'WTC\Instagram\Model\ResourceModel\Instagram');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>