<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Model\ResourceModel;

class GiftCards extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
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
        $this->_init('mageworx_giftcards_card', 'card_id');
        $this->date = date('Y-m-d H:i:s', time());
    }
    
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        if ($object->isObjectNew() && !$object->hasCardCode()) {
            if (!$object->getCardBalance()) {
                $object->setCardBalance($object->getCardAmount());
            }
            $object->setCardCode($this->_getUniqueCardCode());
            $object->setCreatedTime($this->date);
        }
        
        if (strlen($object->getCardCurrency()) != 3) {
            $object->setCardCurrency('');
        }
        
        $object->setCardCurrency(strtoupper($object->getCardCurrency()));
        
        $object->setUpdatedAt($this->date);

        return parent::_beforeSave($object);
    }
    
    public function load(\Magento\Framework\Model\AbstractModel $object, $value, $field = null)
    {
        if (!is_numeric($value) && $field === null) {
            $field = 'card_code';
        }
        
        return parent::load($object, $value, $field);
    }
    
    /**
     * Get Gift Card identifier by Gift Card Code
     *
     * @param string $giftCardCode
     * @return int|false
     */
    public function getIdByCardCode($giftCardCode)
    {
        $connection = $this->getConnection();

        $select = $connection->select()->from($this->getMainTable(), 'card_id')->where('card_code = :giftCardCode');

        $bind = [':giftCardCode' => (string)$giftCardCode];

        return $connection->fetchOne($select, $bind);
    }

    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);
        return $select;
    }
    
    /*
     * Retrive load select with filter bu card_code and card_state
     */
    protected function _getLoadByCardCodeSelect($cardCode, $state = null)
    {
        $select = $this->getConnection()->select()
                                         ->from(['giftcards' => $this->getMainTable()])
                                         ->where('giftcards.card_code = ?', $cardCode);
        if ($state !== null) {
            $select->where('giftcards.card_state = ?', $state);
        }
        
        return $select;
    }
    
    public function loadCustomerCardsWithOrders($email)
    {
        $connection = $this->getConnection();
        $select = $connection->select()
                             ->from(['giftcards' => $this->getMainTable()])
                             ->where('giftcards.mail_to_email = ? and orders.discounted is not null', $email)
                             ->joinLeft(
                                 ['orders' => $this->getTable('mageworx_giftcard_order')],
                                 'orders.giftcard_id = giftcards.card_id',
                                 [
                                             'apply_order_id' => 'orders.order_id',
                                             'discounted'     => 'orders.discounted',
                                             'apply_created_time' => 'orders.created_time'
                                         ]
                             );

        $data = $connection->fetchAll($select);
        return $data;
    }

    protected function _getUniqueCardCode()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $mask = '#####-#####-#####';

        $cardCode = $mask;
        while (strpos($cardCode, '#') !== false) {
            $cardCode = substr_replace($cardCode, $characters[mt_rand(0, strlen($characters)-1)], strpos($cardCode, '#'), 1);
        }
        
        return $cardCode;
    }
}
