<?php
namespace Amasty\Storelocator\Helper;

class Detail extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $resource;

    public function __construct(\Magento\Framework\App\ResourceConnection $resource){
        $this->resource = $resource;
    }


    public function getStoreInfo($id)
    {
        $db =  $this->resource->getConnection();
        $select = $db->select()
            ->from($this->resource->getTableName('amasty_amlocator_location'))
            ->where("id = $id");

        if($storeData = $db->fetchRow($select)){
            return $storeData;
        }else{
            return false;
        }
    }

}