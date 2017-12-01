<?php
namespace Cna\Catalogue\Model\ResourceModel;
class Customers extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('cna_catalogue_customers','cna_catalogue_customers_id');
    }
}
