<?php
namespace Cna\Landing\Setup\Cna\Landing\Model\Entity\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Icons extends AbstractSource
{
    public function getAllOptions()
    {
        return [
            ['value' => 'preservatives', 'label' => __('Preservative Free')],
            ['value' => 'gluten', 'label' => __('Gluten Free')],
            ['value' => 'gmo', 'label' => __('Not From GMO')],
            ['value' => 'vegen', 'label' => __('Vegan')],
            ['value' => 'microwave', 'label' => __('Microwaveable')]
        ];
    }
}
