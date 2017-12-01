<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Dbl\Table;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $connection = $installer->getConnection();

        $tableGiftCardOld = $installer->getTable('giftcards_giftcard');
        $tableOrdersOld   = $installer->getTable('giftcard_order');
        $tableGiftCardNew = $installer->getTable('mageworx_giftcards_card');
        $tableOrdersNew   = $installer->getTable('mageworx_giftcard_order');

        if ($installer->tableExists('giftcards_giftcard')) {
            $connection->renameTable($tableGiftCardOld, $tableGiftCardNew);
        } else {
            /**
             * Create table 'mageworx_giftcards_card'
             */
            $table = $installer->getConnection()->newTable(
                $installer->getTable('mageworx_giftcards_card')
            )->addColumn(
                'card_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity Id'
            )->addColumn(
                'card_code',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Gift Card Code'
            )->addColumn(
                'customer_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Gift Card Customer Id'
            )->addColumn(
                'order_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Gift Card Order Id'
            )->addColumn(
                'product_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Gift Card Product Id'
            )->addColumn(
                'card_currency',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                3,
                [],
                'Gift Card Currency'
            )->addColumn(
                'card_amount',
                \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                '12,4',
                [],
                'Gift Card Amount'
            )->addColumn(
                'card_balance',
                \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                '12,4',
                [],
                'Gift Card Current Balance'
            )->addColumn(
                'card_status',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'default' => '0'],
                'Gift Card Status'
            )->addColumn(
                'card_type',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'default' => '0'],
                'Gift Card Type'
            )->addColumn(
                'mail_from',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Gift Card Mail Sender'
            )->addColumn(
                'mail_to',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Gift Card Owner'
            )->addColumn(
                'mail_to_email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Gift Card Owner Email'
            )->addColumn(
                'mail_message',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [],
                'Gift Card Email Message'
            )->addColumn(
                'offline_country',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Offline Gift Card Country'
            )->addColumn(
                'offline_state',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Offline Gift Card State'
            )->addColumn(
                'offline_city',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Offline Gift Card City'
            )->addColumn(
                'offline_street',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Offline Gift Card Street'
            )->addColumn(
                'offline_zip',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Offline Gift Card ZIP'
            )->addColumn(
                'offline_phone',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Offline Gift Card Phone'
            )->addColumn(
                'mail_delivery_date',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
                null,
                ['nullable' => true],
                'Gift Card Mail Delivery Date'
            )->addColumn(
                'created_time',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Created At'
            )->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                'Updated At'
            );
            $installer->getConnection()->createTable($table);
        }

        if ($installer->tableExists('giftcard_order')) {
            $connection->renameTable($tableOrdersOld, $tableOrdersNew);
        } else {
           /*
           * Create table 'mageworx_giftcard_order'
           */
            $table = $installer->getConnection()->newTable(
                $installer->getTable('mageworx_giftcard_order')
            )->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity Id'
            )->addColumn(
                'giftcard_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Used Gift Card Id'
            )->addColumn(
                'order_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Order Id for used Gift Card'
            )->addColumn(
                'discounted',
                \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                '12,4',
                [],
                'Gift Card Used Amount'
            )->addColumn(
                'created_time',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Created At'
            )->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                'Updated At'
            );
            $installer->getConnection()->createTable($table);

            $installer->getConnection()
                ->addColumn(
                    $installer->getTable('quote'),
                    'mageworx_giftcards_description',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => 255,
                        'comment' => 'MageWorx Gift Card Description',
                    ]
                );

            $installer->getConnection()
                ->addColumn(
                    $installer->getTable('quote'),
                    'mageworx_giftcards_amount',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                        'length' => "12,4",
                        'comment' => 'MageWorx Gift Card Discount Amount',
                    ]
                );

            $installer->getConnection()
                ->addColumn(
                    $installer->getTable('quote'),
                    'base_mageworx_giftcards_amount',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                        'length' => "12,4",
                        'comment' => 'MageWorx Gift Card Base Discount Amount',
                    ]
                );

            $installer->getConnection()
                ->addColumn(
                    $installer->getTable('sales_order'),
                    'mageworx_giftcards_description',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => 255,
                        'comment' => 'MageWorx Gift Card Description',
                    ]
                );

            $installer->getConnection()
                ->addColumn(
                    $installer->getTable('sales_order'),
                    'mageworx_giftcards_amount',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                        'length' => "12,4",
                        'comment' => 'MageWorx Gift Card Discount Amount',
                    ]
                );
        }

        $installer->getConnection()
            ->addColumn(
                $installer->getTable('sales_order'),
                'base_mageworx_giftcards_amount',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' => "12,4",
                    'comment' => 'MageWorx Gift Card Base Discount Amount',
                ]
            );
        
        $installer->endSetup();
    }
}
