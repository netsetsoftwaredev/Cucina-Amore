<?php

namespace WTC\Career\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();
		
		$table = $installer->getConnection()->newTable($installer->getTable('wtc_career'))
         ->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Id'
        )->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Title'
		)->addColumn(
			'url',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => false, 'default' => '0'],
			'url'
		)->addColumn(
			'location',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true, 'default' => '0'],
			'Location'
		)->addColumn(
			'category',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true, 'default' => NULL],
			'Category'
		)->addColumn(
			'position',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true, 'default' => NULL],
			'Position'
		)->addColumn(
			'description',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			'2M',
			['nullable' => true, 'default' => NULL],
			'Description'
		)->addColumn(
			'is_active',
			\Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
			1,
			['nullable' => true, 'default' => '0'],
			'Is Active'
		)->addColumn(
			'updated_at',
			\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
			NULL,
			['nullable' => true,'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
			'Updated at'
		)
		->setComment(
			'WTC Career table' 
		);
		
		$installer->getConnection()->createTable($table);

        $installer->endSetup();

    }
}