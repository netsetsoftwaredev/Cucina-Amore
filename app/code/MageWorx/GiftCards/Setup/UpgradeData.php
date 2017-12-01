<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Setup;

use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Setup\CategorySetupFactory;

/**
 * Upgrade Data script
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * Category setup factory
     *
     * @var CategorySetupFactory
     */
    protected $categorySetupFactory;

    /**
     * Init
     *
     * @param CategorySetupFactory $categorySetupFactory
     */
    public function __construct(CategorySetupFactory $categorySetupFactory)
    {
        $this->categorySetupFactory = $categorySetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $categorySetupManager = $this->categorySetupFactory->create();

        if (version_compare($context->getVersion(), '2.1.0') < 0) {
            $categorySetupManager->removeAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'wts_gc_type'
            );
            $categorySetupManager->removeAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'wts_gc_additional_price'
            );
            
            $categorySetupManager->addAttribute(
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

            $categorySetupManager->addAttribute(
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

            $entityTypeId = $categorySetupManager->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
            $defaultEntities = $categorySetupManager->getDefaultEntities();
        
            foreach ($defaultEntities['catalog_product']['attributes'] as $code => $attribute) {
                $applyTo = explode(',', $categorySetupManager->getAttribute($entityTypeId, $code, 'apply_to'));
                if (!in_array(\MageWorx\GiftCards\Model\Product\Type\GiftCards::TYPE_CODE, $applyTo) && in_array('simple', $applyTo)) {
                    $applyTo[] = \MageWorx\GiftCards\Model\Product\Type\GiftCards::TYPE_CODE;
                    $categorySetupManager->updateAttribute($entityTypeId, $code, 'apply_to', implode(',', $applyTo));
                }
            }
        }
    
        $setup->endSetup();
    }
}
