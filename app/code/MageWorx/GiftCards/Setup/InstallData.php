<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Setup\CategorySetupFactory;

class InstallData implements InstallDataInterface
{
    protected $categorySetupFactory;

    public function __construct(CategorySetupFactory $categorySetupFactory)
    {
        $this->categorySetupFactory = $categorySetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);
        $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);

        $categorySetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'mageworx_gc_type',
            [
                'label'            => 'Giftcards Type',
                'group'            => 'Product Details',
                'required'         => true,
                'visible_on_front' => true,
                'apply_to'         => \MageWorx\GiftCards\Model\Product\Type\GiftCards::TYPE_CODE,
                'input'            => 'select',
                'source'           => 'MageWorx\GiftCards\Model\GiftCards\Source\Types',
            ]
        );

        $categorySetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'mageworx_gc_additional_price',
            [
                'label'            => 'Predefined Prices',
                'group'            => 'Product Details',
                'required'         => false,
                'visible_on_front' => true,
                'apply_to'         => \MageWorx\GiftCards\Model\Product\Type\GiftCards::TYPE_CODE,
                'note'             => 'List here possible gift card prices to be selected from the dropdown on the frontend. Separate them by semicolon.',
                'sort_order'       => 35,
                'backend'          => 'MageWorx\GiftCards\Model\GiftCards\Backend\AdditionalPrice',
            ]
        );

        $defaultEntities = $categorySetup->getDefaultEntities();
        
        foreach ($defaultEntities['catalog_product']['attributes'] as $code => $attribute) {
            $applyTo = explode(',', $categorySetup->getAttribute($entityTypeId, $code, 'apply_to'));
            if (!in_array(\MageWorx\GiftCards\Model\Product\Type\GiftCards::TYPE_CODE, $applyTo) && in_array('simple', $applyTo)) {
                $applyTo[] = \MageWorx\GiftCards\Model\Product\Type\GiftCards::TYPE_CODE;
                $categorySetup->updateAttribute($entityTypeId, $code, 'apply_to', implode(',', $applyTo));
            }
        }

        $setup->endSetup();
    }
}
