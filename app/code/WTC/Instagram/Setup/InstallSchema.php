<?php

namespace WTC\Instagram\Setup;

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
		
		$table = $installer->getConnection()->newTable($installer->getTable('wtc_instagram_images'))
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
            ['nullable' => true],
            'Title'
		)->addColumn(
			'image',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => true, 'default' => '0'],
			'Image'
		)
		->addColumn(
			'source',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			50,
			['nullable' => true, 'default' => '0'],
			'Source'
		)
		->setComment(
			'WTC Instagram Images table' 
		);
		
		$installer->getConnection()->createTable($table);

        $installer->endSetup();

    }
}