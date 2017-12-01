<?php
/**
 * @category Mageants ExtraFee
 * @package Mageants_ExtraFee
 * @copyright Copyright (c) 2017 Mageants
 * @author Mageants Team <support@mageants.com>
 */
namespace Rocktechnolabs\CLP\Model\Source;
/**
 * Return Extra fee list
 */
class FlavorList extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    
    /**
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param \Magento\Catalog\Model\Category $categories
     */
    public function __construct(
        \Rocktechnolabs\CLP\Model\Flavor $flavorCollection
    ) {
        $this->_collection = $flavorCollection;
    }
  
    /**
     * @return Array
     */
    public function getAllOptions()
    {
        $collection = $this->_collection->getCollection();
        $options=array();
        foreach ($collection as $flavor) 
        {
            $flavorData=$flavor->getData();
            $options[$flavorData['flavor_id']]=array('value'=>$flavorData['flavor_id'],'label'=>__($flavorData['fname']));
        }
        return $options;
    }
}
