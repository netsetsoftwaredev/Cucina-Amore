<?php

namespace WTC\Career\Model\ResourceModel\Career;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('WTC\Career\Model\Career', 'WTC\Career\Model\ResourceModel\Career');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>