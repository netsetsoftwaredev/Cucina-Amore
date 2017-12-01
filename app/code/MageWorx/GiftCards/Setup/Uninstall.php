<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Catalog\Setup\CategorySetupFactory;

class Uninstall implements UninstallInterface
{
    
    protected $categorySetupFactory;

    public function __construct(CategorySetupFactory $categorySetupFactory)
    {
        $this->categorySetupFactory = $categorySetupFactory;
    }

    /**
     * Module uninstall code
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function uninstall(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();

        $connection = $setup->getConnection();
        $connection->dropTable($connection->getTableName('mageworx_giftcards_card'));
        $connection->dropTable($connection->getTableName('mageworx_giftcard_order'));
        
        $categorySetupManager = $this->categorySetupFactory->create();
    
        $categorySetupManager->removeAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'mageworx_gc_type'
        );
        $categorySetupManager->removeAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'mageworx_gc_additional_price'
        );
        $categorySetupManager->removeAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'wts_gc_type'
        );
        $categorySetupManager->removeAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'wts_gc_additional_price'
        );

        $setup->endSetup();
    }
}
