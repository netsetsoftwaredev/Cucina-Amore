<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_Storelocator
 */


namespace Amasty\Storelocator\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\Backend\Media;
use Magento\Framework\DB\Adapter\AdapterInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.1.0', '<')) {
            $this->addStoreIds($setup);
        }
        if (version_compare($context->getVersion(), '1.2.0', '<')) {
            $this->addTimeSchedule($setup);
            $this->addAttributeTables($setup);
        }
        if (version_compare($context->getVersion(), '1.3.0', '<')) {
            $this->addMarkerImg($setup);
        }

        $setup->endSetup();
    }

    protected function addStoreIds(SchemaSetupInterface $setup)
    {
        $setup->getConnection()->addColumn(
            $setup->getTable('amasty_amlocator_location'),
            'stores',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => false,
                'default' => '',
                'comment' => 'Stores Ids'
            ]
        );

        $setup->getConnection()->changeColumn(
            $setup->getTable('amasty_amlocator_location'),
            'actions_serialize',
            'actions_serialized',
            ['type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 'nullable' => true, 'comment' => 'Actions Serialized']
        );

        $setup->getConnection()->dropTable(
            $setup->getTable('amasty_amlocator_location_category')
        );
        $setup->getConnection()->dropTable(
            $setup->getTable('amasty_amlocator_location_product')
        );
        $setup->getConnection()->dropTable(
            $setup->getTable('amasty_amlocator_location_store')
        );
    }

    protected function addTimeSchedule(SchemaSetupInterface $setup)
    {
        $setup->getConnection()->addColumn(
            $setup->getTable('amasty_amlocator_location'),
            'schedule',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => false,
                'default' => '',
                'comment' => 'Stores Schedule'
            ]
        );
    }

    protected function addAttributeTables(SchemaSetupInterface $setup)
    {
        $table  = $setup->getConnection()
            ->newTable($setup->getTable('amasty_amlocator_attribute'))
            ->addColumn(
                'attribute_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Attribute Id'
            )->addColumn(
                'frontend_label',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => true, 'nullable' => false],
                'Default Label'
            )
            ->addColumn(
                'attribute_code',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => true, 'nullable' => false],
                'Attribute Code'
            )
            ->addColumn(
                'frontend_input',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                50,
                ['unsigned' => true, 'nullable' => false],
                'Frontend Input'
            )
            ->addColumn(
                'is_required',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                5,
                ['unsigned' => true, 'nullable' => true],
                'Is Required'
            )
            ->addColumn(
                'label_serialized',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '64k',
                ['unsigned' => true, 'nullable' => true],
                'Attribute Labels by store'
            );
        $setup->getConnection()->createTable($table);


        $table  = $setup->getConnection()
            ->newTable($setup->getTable('amasty_amlocator_attribute_option'))
            ->addColumn(
                'value_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Value Id'
            )->addColumn(
                'attribute_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Attribute Id'
            )
            ->addColumn(
                'options_serialized',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '64k',
                ['unsigned' => true, 'nullable' => true],
                'Value And Store'
            )
            ->addColumn(
                'is_default',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '64k',
                ['unsigned' => true, 'nullable' => true],
                'This is Default Option'
            )
            ->addIndex(
                $setup->getIdxName('amasty_amlocator_attribute_option', ['attribute_id']),
                ['attribute_id']
            )
            ->addForeignKey(
                $setup->getFkName(
                    'amasty_amlocator_attribute_option',
                    'attribute_id',
                    'amasty_amlocator_attribute',
                    'attribute_id'
                ),
                'attribute_id',
                $setup->getTable('amasty_amlocator_attribute'),
                'attribute_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            );
        $setup->getConnection()->createTable($table);

        $table  = $setup->getConnection()
            ->newTable($setup->getTable('amasty_amlocator_store_attribute'))
            ->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity Id'
            )
            ->addColumn(
                'attribute_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Attribute Id'
            )
            ->addColumn(
                'store_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Store Location Id'
            )
            ->addColumn(
                'value',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => true, 'nullable' => false],
                'Attribute Value'
            )
            ->addIndex(
                $setup->getIdxName('amasty_amlocator_store_attribute', ['attribute_id']),
                ['attribute_id']
            )
            ->addForeignKey(
                $setup->getFkName(
                    'amasty_amlocator_store_attribute',
                    'attribute_id',
                    'amasty_amlocator_attribute',
                    'attribute_id'
                ),
                'attribute_id',
                $setup->getTable('amasty_amlocator_attribute'),
                'attribute_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->addIndex(
                $setup->getIdxName(
                    'amasty_amlocator_store_attribute',
                    ['attribute_id', 'store_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['attribute_id', 'store_id'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            );
        $setup->getConnection()->createTable($table);

    }

    protected function addMarkerImg(SchemaSetupInterface $setup)
    {
        $setup->getConnection()->addColumn(
            $setup->getTable('amasty_amlocator_location'),
            'marker_img',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => false,
                'default' => '',
                'comment' => 'Marker Image'
            ]
        );
    }
}
