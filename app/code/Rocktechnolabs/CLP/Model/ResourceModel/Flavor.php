<?php
/**
 * @category Rocktechnolabs CLP
 * @package Rocktechnolabs_CLP
 * @copyright Copyright (c) 2017 Rocktechnolabs
 * @author Rocktechnolabs Team <support@rocktechnolabs.com>
 */
namespace Rocktechnolabs\CLP\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Model\AbstractModel;

/**
 * CLP resource Model
 */
class Flavor extends AbstractDb
{
    const TBL_ATT_PRODUCT = 'flavor_product';
    /**
     * @var $_date
     */
    protected $_date;
    /**
     * @param Context 
     * @param DateTime 
     */    
    public function __construct(
        Context $context,
        DateTime $date,
        $resourcePrefix = null
    ) 
    {
        parent::__construct($context, $resourcePrefix);
        $this->_date = $date;
    }

    protected function _construct()
    {
        $this->_init('rock_flavor', 'flavor_id');
    }

    /**
     * Check before save model
     *
     * @param AbstractModel $object
     * @return parent::_beforeSave
     */
    protected function _beforeSave(AbstractModel $object)
    {
        if ($object->isObjectNew() && !$object->hasCreationTime()) {
            $object->setCreationTime($this->_date->gmtDate());
        }
        $object->setUpdateTime($this->_date->gmtDate());
        return parent::_beforeSave($object);
    }

    /**
     * Get Load select
     *
     * @param string $field
     * @param string $value
     * @param string $object
     * @return $select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);
        if ($object->getStoreId()) {
            $select->where(
                'is_active = ?',
                1
            )->limit(
                1
            );
        }
        return $select;
    }
}
