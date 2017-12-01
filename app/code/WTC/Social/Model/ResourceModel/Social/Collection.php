<?php

namespace WTC\Social\Model\ResourceModel\Social;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('WTC\Social\Model\Social', 'WTC\Social\Model\ResourceModel\Social');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>