<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Model\ResourceModel;

class Order extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    
    protected $date;
    
    public function __counstruct(
        \Magento\Framework\Model\Resource\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        $resourcePrefix = null
    ) {
    
        parent::__construct($context, $resourcePrefix);
        $this->date = $date;
    }
      
    protected function _construct()
    {
        $this->_init('mageworx_giftcard_order', 'entity_id');
        $this->date = date('Y-m-d H:i:s', time());
    }
    
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        if ($object->isObjectNew() && !$object->hasCardCode()) {
            $object->setCreatedTime($this->date);
        }
        
        $object->setUpdatedAt($this->date);

        return parent::_beforeSave($object);
    }
    
    public function load(\Magento\Framework\Model\AbstractModel $object, $value, $field = null)
    {
        return parent::load($object, $value, $field);
    }
    
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);
        return $select;
    }
}
