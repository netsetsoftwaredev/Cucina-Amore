<?php
namespace Cna\Catalogue\Model\ResourceModel\Customers;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Cna\Catalogue\Model\Customers','Cna\Catalogue\Model\ResourceModel\Customers');
    }
}
