<?php

namespace WTC\Social\Setup;

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
		
		$table = $installer->getConnection()->newTable($installer->getTable('wtc_social'))
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
		)
		->addColumn(
			'image',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => false, 'default' => '0'],
			'Image'
		)
		->addColumn(
			'type',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			50,
			['nullable' => false, 'default' => '0'],
			'type'
		)
		->setComment(
			'WTC Social table' 
		);
		
		$installer->getConnection()->createTable($table);

        $installer->endSetup();

    }
}