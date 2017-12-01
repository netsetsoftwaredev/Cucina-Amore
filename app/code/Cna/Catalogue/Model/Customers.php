<?php
namespace Cna\Catalogue\Model;
class Customers extends \Magento\Framework\Model\AbstractModel implements \Cna\Catalogue\Api\Data\CustomersInterface, \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'cna_catalogue_customers';

    protected function _construct()
    {
        $this->_init('Cna\Catalogue\Model\ResourceModel\Customers');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
