<?php 
/**
 * @category Rocktechnolabs CLP
 * @package Rocktechnolabs_CLP
 * @copyright Copyright (c) 2017 Rocktechnolabs
 * @author Rocktechnolabs Team <support@rocktechnolabs.com>
 */
namespace Rocktechnolabs\CLP\Model;
use Magento\Framework\Model\AbstractModel;
/**
 * CLP Model
 */
class Flavor extends AbstractModel
{

    /**
     * init CLP
     */
    protected function _construct()
    {
        $this->_init('Rocktechnolabs\CLP\Model\ResourceModel\Flavor');
    }
    
    /**
     * fetch product for CLP
     *
     * @param \Rocktechnolabs\CLP\Model\CLP  $object
     * @return $string
     */
    public function getProducts(\Rocktechnolabs\CLP\Model\Flavor $object)
    {
        $tbl = $this->getResource()->getTable(\Rocktechnolabs\CLP\Model\ResourceModel\Flavor::TBL_ATT_PRODUCT);
        $select = $this->getResource()->getConnection()->select()->from(
            $tbl,
            ['product_id']
        )
        ->where(
            'flavor_id = ?',
            (int)$object->getId()
        );
        return $this->getResource()->getConnection()->fetchCol($select);
    }
}
