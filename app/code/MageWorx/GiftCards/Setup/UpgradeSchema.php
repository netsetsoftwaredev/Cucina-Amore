<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        // update ptoduct type
        $installer->run("UPDATE IGNORE `{$installer->getTable('catalog_product_entity')}` SET `type_id` = 'mageworx_giftcards' WHERE `type_id` LIKE 'giftcards'");

        // update config path
        $installer->run("UPDATE IGNORE `{$installer->getTable('core_config_data')}` SET `path` = REPLACE(`path`,'mageworx_giftcards/main/','mageworx_giftcards/mageworx_default/') WHERE `path` LIKE 'mageworx_giftcards/main/%'");
        $installer->run("UPDATE IGNORE `{$installer->getTable('core_config_data')}` SET `path` = REPLACE(`path`,'mageworx_giftcards/email/','mageworx_giftcards/mageworx_email/') WHERE `path` LIKE 'mageworx_giftcards/email/%'");

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
