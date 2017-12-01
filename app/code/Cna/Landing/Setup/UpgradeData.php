<?php
/**
 * Copyright © 2016 SW-THEMES. All rights reserved.
 */

namespace Cna\Landing\Setup;

use Magento\Framework\Module\Setup\Migration;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Model\Category;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (version_compare($context->getVersion(), '0.0.3', '<')) {
            /** @var EavSetup $eavSetup */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                Category::ENTITY,
                'landing_main_head',
                [
                    'type' => 'varchar',
                    'label' => 'Main Head Image',
                    'input' => 'image',
                    'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                    'required' => false,
                    'global' => ScopedAttributeInterface::SCOPE_STORE,
                    'group' => 'Landing',
                ]
            );

        }
        if (version_compare($context->getVersion(), '0.0.3', '<=')) {
            /** @var EavSetup $eavSetup */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_headling_desc',
                'is_wysiwyg_enabled',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_headling_desc',
                'is_html_allowed_on_front',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_how_content1',
                'is_wysiwyg_enabled',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_how_content1',
                'is_html_allowed_on_front',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_how_content2',
                'is_wysiwyg_enabled',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_how_content2',
                'is_html_allowed_on_front',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_what_content1',
                'is_wysiwyg_enabled',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_what_content1',
                'is_html_allowed_on_front',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_what_content2',
                'is_wysiwyg_enabled',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_what_content2',
                'is_html_allowed_on_front',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_where_content1',
                'is_wysiwyg_enabled',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_where_content1',
                'is_html_allowed_on_front',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_where_content2',
                'is_wysiwyg_enabled',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_where_content2',
                'is_html_allowed_on_front',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_life_desc1',
                'is_wysiwyg_enabled',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_life_desc1',
                'is_html_allowed_on_front',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_life_desc2',
                'is_wysiwyg_enabled',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_life_desc2',
                'is_html_allowed_on_front',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_nutrition_desc',
                'is_wysiwyg_enabled',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_nutrition_desc',
                'is_html_allowed_on_front',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_seo',
                'is_wysiwyg_enabled',
                1
            );
            $eavSetup->updateAttribute(
                Category::ENTITY,
                'landing_seo',
                'is_html_allowed_on_front',
                1
            );
        }
        $setup->endSetup();
    }
}

