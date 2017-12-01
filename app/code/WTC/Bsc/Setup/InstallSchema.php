<?php

namespace WTC\Bsc\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
	//$installer->run('create table wtc_business_customers(id int not null auto_increment, email varchar(255),password varchar(255), primary key(id))');

	
	public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();


        $table = $installer->getConnection()->newTable(
        $installer->getTable('wtc_business_customers'))
         ->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Id'
        )->addColumn(
            'email',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Name'
			)->addColumn(
				'password',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				255,
				['nullable' => false, 'default' => '0'],
				'Phone'
			)->setComment(
				'WTC Business Customers table'
			);
			$installer->getConnection()->createTable($table);

			$installer->endSetup();
	}
}