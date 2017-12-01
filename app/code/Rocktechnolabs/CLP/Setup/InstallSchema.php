<?php 
/**
 * @category Rocktechnolabs CLP
 * @package Rocktechnolabs_CLP
 * @copyright Copyright (c) 2017 Rocktechnolabs
 * @author Rocktechnolabs Team <support@rocktechnolabs.com>
 */
namespace Rocktechnolabs\CLP\Setup;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Store\Model\StoreManagerInterface;
/**
 * InstallSchema for create Table
 */
class InstallSchema implements InstallSchemaInterface
{
    protected $StoreManager;     
    /**     * Init     *     * @param EavSetupFactory $eavSetupFactory     */    
    public function __construct(StoreManagerInterface $StoreManager)   
    {        
        $this->StoreManager=$StoreManager;    
    }

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        /**
         * Create Database Table
         */
        $installer = $setup;
        $installer->startSetup();
       
        if(!$installer->tableExists('rock_clp')) {
         $table = $installer->getConnection()
            ->newTable(
                $installer->getTable('rock_clp')
            )->addColumn(
                'clp_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'CLP Id'
            )->addColumn(
                'ctitle',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                'clp Title'
            )
            ->addColumn(
                'clp_url',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                'clp status'
            )
            ->addColumn(
                '1bimage',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '1 sec. back image'
            )
            ->addColumn(
                '1title',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '1 sec. title'
            )
            ->addColumn(
                '1description',
                Table::TYPE_TEXT,
                '',
                ['nullable'  => false,],
                '1 sec. description'
            )
            ->addColumn(
                '1shoplink',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '1 sec Shop Link'
            )
            ->addColumn(
                '1buylink',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '1 sec. buy link'
            )
            ->addColumn(
                '2title',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '2 sec Title'
            )
            ->addColumn(
                '2description',
                Table::TYPE_TEXT,
                '',
                ['nullable'  => false,],
                '2 sec description'
            )
            ->addColumn(
                '2hwbimage1',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '2 sec how Background image1'
            )
            ->addColumn(
                '2hwimage1',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '2 sec how image1'
            )
            ->addColumn(
                '2hwcontent1',
                Table::TYPE_TEXT,
                '',
                ['nullable'  => false,],
                '2 sec how content 1'
            )
            ->addColumn(
                '2hwbimage2',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '2 sec how Background image 2'
            )
            ->addColumn(
                '2hwimage2',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '2 sec how image 2'
            )
            ->addColumn(
                '2hwcontent2',
                Table::TYPE_TEXT,
                '',
                ['nullable'  => false,],
                '2 sec how content 2'
            )
            ->addColumn(
                '2wtbimage1',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '2 sec what Background image1'
            )
            ->addColumn(
                '2wtimage1',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '2 sec whatt image1'
            )
            ->addColumn(
                '2wtcontent1',
                Table::TYPE_TEXT,
                '',
                ['nullable'  => false,],
                '2 sec what content 1'
            )
            ->addColumn(
                '2wtbimage2',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '2 sec what Background image1'
            )
            ->addColumn(
                '2wtimage2',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '2 sec what image2'
            )
            ->addColumn(
                '2wtcontent2',
                Table::TYPE_TEXT,
                '',
                ['nullable'  => false,],
                '2 sec what content 2'
            )
            ->addColumn(
                '2webimage1',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '2 sec where Background image1'
            )
            ->addColumn(
                '2weimage1',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '2 sec where image1'
            )
            ->addColumn(
                '2wecontent1',
                Table::TYPE_TEXT,
                '',
                ['nullable'  => false,],
                '2 sec where content 2'
            )
            ->addColumn(
                '2webimage2',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '2 sec where Background image2'
            )
            ->addColumn(
                '2weimage2',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '2 sec where image2'
            )
            ->addColumn(
                '2wecontent2',
                Table::TYPE_TEXT,
                '',
                ['nullable'  => false,],
                '2 sec where content 2'
            )
            ->addColumn(
                '3title1',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '3 sec top title'
            )
            ->addColumn(
                '3description1',
                Table::TYPE_TEXT,
                '',
                ['nullable'  => false,],
                '3 sec top description'
            )
            ->addColumn(
                '3title2',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '2 sec second title'
            )
            ->addColumn(
                '3description2',
                Table::TYPE_TEXT,
                '',
                ['nullable'  => false,],
                '3 sec description 2'
            )
            ->addColumn(
                '3bimage2',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '3 section background Image'
            )
            ->addColumn(
                '3image31',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '3 section image 3_1'
            )
            ->addColumn(
                '3image32',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '3 section image 3_2'
            )
            ->addColumn(
                '3description3',
                Table::TYPE_TEXT,
                '',
                ['nullable'  => false,],
                '3 sec description 3'
            )
            ->addColumn(
                '4nutritionicon',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '4 sec nutrition icon'
            )
            ->addColumn(
                '4nutritionfact',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '4 sec nutrition fact'
            )
            ->addColumn(
                '4nutritiontitle',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '4 sec nutrition title'
            )
            ->addColumn(
                '4nutritiondesc',
                Table::TYPE_TEXT,
                '',
                ['nullable'  => false,],
                '4 sec nutrition desc'
            )
            ->addColumn(
                '4nutritionimage',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '4 sec nutrition image'
            )
            ->addColumn(
                '5flavor_id',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '5 sec Flavor Id'
            )
            ->addColumn(
                '5bimage',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                '5 background Flavor Image'
            )
            ->addColumn(
                '6content',
                Table::TYPE_TEXT,
                '',
                ['nullable'  => false,],
                '6 sec content'
            )
            ->addColumn(
                'product_id',
                Table::TYPE_TEXT,
                255,
                [],
                'product Id'
            )
            ->addIndex(  
                $setup->getIdxName(  
                    $setup->getTable('rock_clp'),  
                    ['ctitle', 'clp_url'],  
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT  
                ),  
                ['ctitle', 'clp_url'],
                ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT]
            )->setComment(
                'Rocktechnolabs CLP  Table'
            );
        $setup->getConnection()->createTable($table);
        }    
        
        if (!$installer->tableExists('clp_product')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('clp_product'))
                ->addColumn('clp_id', Table::TYPE_INTEGER, 10, ['nullable' => false, 'unsigned' => true])
                ->addColumn('product_id', Table::TYPE_INTEGER, 10, ['nullable' => false, 'unsigned' => true], 'Magento Product Id')
                ->addForeignKey(
                    $installer->getFkName(
                        'rock_clp',
                        'clp_id',
                        'clp_product',
                        'clp_id'
                    ),
                    'clp_id',
                    $installer->getTable('rock_clp'),
                    'clp_id',
                    Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'clp_product',
                        'clp_id',
                        'catalog_product_entity',
                        'entity_id'
                    ),
                    'product_id',
                    $installer->getTable('catalog_product_entity'),
                    'entity_id',
                    Table::ACTION_CASCADE
                )
                ->setComment('Rocktechnolabs CLP relation table');

            $installer->getConnection()->createTable($table);
        }

        if(!$installer->tableExists('rock_flavor')) {
         $table = $installer->getConnection()
            ->newTable(
                $installer->getTable('rock_flavor')
            )->addColumn(
                'flavor_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Flavor Id'
            )->addColumn(
                'fname',
                Table::TYPE_TEXT,
                255,
                ['nullable'  => false,],
                'Flavor Title'
            )->addColumn(
                'fdescription',
                Table::TYPE_TEXT,
                '',
                ['nullable'  => false,],
                'Flavor description'
            )
            ->addColumn(
                'product_id',
                Table::TYPE_TEXT,
                255,
                [],
                'Flavor product Id'
            )
            ->addIndex(  
                $setup->getIdxName(  
                    $setup->getTable('rock_flavor'),  
                    ['fname', 'fdescription'],  
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT  
                ),  
                ['fname', 'fdescription'],
                ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT]
            )->setComment(
                'Rocktechnolabs CLP Flavor Table'
            );
        $setup->getConnection()->createTable($table);
        }

        if (!$installer->tableExists('flavor_product')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('flavor_product'))
                ->addColumn('flavor_id', Table::TYPE_INTEGER, 10, ['nullable' => false, 'unsigned' => true])
                ->addColumn('product_id', Table::TYPE_INTEGER, 10, ['nullable' => false, 'unsigned' => true], 'Magento Flavor Id')
                ->addForeignKey(
                    $installer->getFkName(
                        'rock_flavor',
                        'flavor_id',
                        'flavor_product',
                        'flavor_id'
                    ),
                    'flavor_id',
                    $installer->getTable('rock_flavor'),
                    'flavor_id',
                    Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'flavor_product',
                        'flavor_id',
                        'catalog_product_entity',
                        'entity_id'
                    ),
                    'product_id',
                    $installer->getTable('catalog_product_entity'),
                    'entity_id',
                    Table::ACTION_CASCADE
                )
                ->setComment('Rocktechnolabs CLP flavor relation table');

            $installer->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }
}
