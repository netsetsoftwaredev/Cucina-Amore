<?php
namespace Cna\Catalogue\Api;

use Cna\Catalogue\Api\Data\CustomersInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface CustomersRepositoryInterface 
{
    public function save(CustomersInterface $page);

    public function getById($id);

    public function getList(SearchCriteriaInterface $criteria);

    public function delete(CustomersInterface $page);

    public function deleteById($id);
}
