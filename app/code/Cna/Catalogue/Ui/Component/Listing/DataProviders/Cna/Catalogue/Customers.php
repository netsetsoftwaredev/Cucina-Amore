<?php
namespace Cna\Catalogue\Ui\Component\Listing\DataProviders\Cna\Catalogue;

class Customers extends \Magento\Ui\DataProvider\AbstractDataProvider
{    
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Cna\Catalogue\Model\ResourceModel\Customers\CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }
}
