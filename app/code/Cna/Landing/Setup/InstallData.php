<?php
/* file: app/code/Atwix/CategoryAttribute/Setup/InstallData.php */

namespace Cna\Landing\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Model\Category;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
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

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            Category::ENTITY,
            'is_landing',
            [
                'type' => 'int',
                'label' => 'Is Landing?',
                'input' => 'select',
      		'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                'required' => false,
                'sort_order' => 100,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_headling',
            [
                'type' => 'varchar',
                'label' => 'Banner Headline',
                'input' => 'text',
                'required' => false,
                'sort_order' => 101,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_headling_desc',
            [
                'type' => 'varchar',
                'label' => 'Banner Description',
                'input' => 'textarea',
                'required' => false,
                'sort_order' => 101,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_headling_link',
            [
                'type' => 'varchar',
                'label' => 'Link to category page',
                'input' => 'text',
                'required' => false,
                'sort_order' => 102,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_cucina_diff',
            [
                'type' => 'varchar',
                'label' => 'Cucina Difference Subhead',
                'input' => 'text',
                'required' => false,
                'sort_order' => 103,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_how_content1',
            [
                'type' => 'varchar',
                'label' => 'How Content 1',
                'input' => 'textarea',
                'required' => false,
                'sort_order' => 104,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_how_content2',
            [
                'type' => 'varchar',
                'label' => 'How Content 2',
                'input' => 'textarea',
                'required' => false,
                'sort_order' => 105,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_how_img1',
            [
                'type' => 'varchar',
                'label' => 'How Image 1',
                'input' => 'image',
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                'required' => false,
                'sort_order' => 108,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_how_img2',
            [
                'type' => 'varchar',
                'label' => 'How Image 2',
                'input' => 'image',
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                'required' => false,
                'sort_order' => 111,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_how_img3',
            [
                'type' => 'varchar',
                'label' => 'How Image 3',
                'input' => 'image',
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                'required' => false,
                'sort_order' => 101,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_how_img4',
            [
                'type' => 'varchar',
                'label' => 'How Image 4',
                'input' => 'image',
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                'required' => false,
                'sort_order' => 101,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_what_content1',
            [
                'type' => 'varchar',
                'label' => 'What Content 1',
                'input' => 'textarea',
                'required' => false,
                'sort_order' => 104,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_what_content2',
            [
                'type' => 'varchar',
                'label' => 'What Content 2',
                'input' => 'textarea',
                'required' => false,
                'sort_order' => 105,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_what_img1',
            [
                'type' => 'varchar',
                'label' => 'What Image 1',
                'input' => 'image',
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                'required' => false,
                'sort_order' => 108,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_what_img2',
            [
                'type' => 'varchar',
                'label' => 'What Image 2',
                'input' => 'image',
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                'required' => false,
                'sort_order' => 111,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_what_img3',
            [
                'type' => 'varchar',
                'label' => 'What Image 3',
                'input' => 'image',
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                'required' => false,
                'sort_order' => 101,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_what_img4',
            [
                'type' => 'varchar',
                'label' => 'What Image 4',
                'input' => 'image',
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                'required' => false,
                'sort_order' => 101,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_where_content1',
            [
                'type' => 'varchar',
                'label' => 'Where Content 1',
                'input' => 'textarea',
                'required' => false,
                'sort_order' => 104,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_where_content2',
            [
                'type' => 'varchar',
                'label' => 'Where Content 2',
                'input' => 'textarea',
                'required' => false,
                'sort_order' => 105,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_where_img1',
            [
                'type' => 'varchar',
                'label' => 'Where Image 1',
                'input' => 'image',
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                'required' => false,
                'sort_order' => 108,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_where_img2',
            [
                'type' => 'varchar',
                'label' => 'Where Image 2',
                'input' => 'image',
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                'required' => false,
                'sort_order' => 111,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_where_img3',
            [
                'type' => 'varchar',
                'label' => 'Where Image 3',
                'input' => 'image',
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                'required' => false,
                'sort_order' => 101,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_where_img4',
            [
                'type' => 'varchar',
                'label' => 'Where Image 4',
                'input' => 'image',
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                'required' => false,
                'sort_order' => 101,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_life_head',
            [
                'type' => 'varchar',
                'label' => 'Cucina and Your Life Subhead',
                'input' => 'text',
                'required' => false,
                'sort_order' => 101,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_life_headline1',
            [
                'type' => 'varchar',
                'label' => 'Cucina and Your Life Headline 1',
                'input' => 'text',
                'required' => false,
                'sort_order' => 101,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );

        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_life_desc1',
            [
                'type' => 'varchar',
                'label' => 'Cucina and Your Life Desc 1',
                'input' => 'textarea',
                'required' => false,
                'sort_order' => 101,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_life_headline2',
            [
                'type' => 'varchar',
                'label' => 'Cucina and Your Life Headline 2',
                'input' => 'text',
                'required' => false,
                'sort_order' => 101,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );

        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_life_desc2',
            [
                'type' => 'varchar',
                'label' => 'Cucina and Your Life Desc 2',
                'input' => 'textarea',
                'required' => false,
                'sort_order' => 101,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_nutrition_icons',
            [
                'type' => 'varchar',
                'label' => 'Nutrition Info Icons',
                'input' => 'multiselect',
		'source' => Cna\Landing\Model\Entity\Attribute\Source\Icons::class,
                'required' => false,
                'sort_order' => 101,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_nutrition_headline',
            [
                'type' => 'varchar',
                'label' => 'Nutrition Headline',
                'input' => 'text',
                'required' => false,
                'sort_order' => 101,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );

        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_nutrition_desc',
            [
                'type' => 'varchar',
                'label' => 'Nutrition Content',
                'input' => 'textarea',
                'required' => false,
                'sort_order' => 101,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_nutrition_facts',
            [
                'type' => 'varchar',
                'label' => 'Nutrition Facts Image',
                'input' => 'image',
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                'required' => false,
                'sort_order' => 111,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_nutrition_prod',
            [
                'type' => 'varchar',
                'label' => 'Nutrition Section Produc Image',
                'input' => 'image',
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                'required' => false,
                'sort_order' => 111,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_prods_related',
            [
                'type' => 'varchar',
                'label' => 'Related Products',
                'input' => 'text',
                'required' => false,
                'sort_order' => 103,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );
        $eavSetup->addAttribute(
            Category::ENTITY,
            'landing_seo',
            [
                'type' => 'varchar',
                'label' => 'SEO Content',
                'input' => 'textarea',
                'required' => false,
                'sort_order' => 101,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Landing',
            ]
        );

    }
}

