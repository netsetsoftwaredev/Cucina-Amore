<?php 
/**
 * @category Rocktechnolabs CLP
 * @package Rocktechnolabs_CLP
 * @copyright Copyright (c) 2017 Rocktechnolabs
 * @author Rocktechnolabs Team <support@rocktechnolabs.com>
 */
namespace Rocktechnolabs\CLP\Model;
use Magento\Framework\Model\AbstractModel;

/**
 * FlavorProduct Model
 */
class FlavorProduct extends AbstractModel
{
    /**
     * init Attach Product
     */
    protected function _construct()
    {
        $this->_init('Rocktechnolabs\CLP\Model\ResourceModel\FlavorProduct');
    }
}
