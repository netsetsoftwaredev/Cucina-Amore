<?php 
/**
 * @category Rocktechnolabs CLP
 * @package Rocktechnolabs_CLP
 * @copyright Copyright (c) 2017 Rocktechnolabs
 * @author Rocktechnolabs Team <support@rocktechnolabs.com>
 */
namespace Rocktechnolabs\CLP\Model\ResourceModel\ClpProduct;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * collection for Attach Product
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'clp_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Rocktechnolabs\CLP\Model\ClpProduct', 'Rocktechnolabs\CLP\Model\ResourceModel\ClpProduct');
    }
}
