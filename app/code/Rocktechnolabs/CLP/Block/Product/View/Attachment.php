<?php
/**
 * @category Rocktechnolabs CLP
 * @package Rocktechnolabs_CLP
 * @copyright Copyright (c) 2017 Rocktechnolabs
 * @author Rocktechnolabs Team <support@rocktechnolabs.com>
 */
namespace Rocktechnolabs\CLP\Block\Product\View;
use Magento\Catalog\Block\Product\AbstractProduct;
/**
 * CLP class in product view
 */
class CLP extends AbstractProduct
{
    /**
     * Attach Product
     *
     * @var \Rocktechnolabs\CLP\Model\ClpProduct
     */
    protected $_attachProduct;
    /**
     * CLP
     *
     * @var \Rocktechnolabs\CLP\Model\CLP
     */
    protected $_productCLP;

    /**
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Rocktechnolabs\CLP\Model\ClpProduct $attachProduct
     * @param \Rocktechnolabs\CLP\Model\CLP $productCLP
     * @param array data[]
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Rocktechnolabs\CLP\Model\ClpProduct $attachProduct,
        \Rocktechnolabs\CLP\Model\CLP $productCLP,
        array $data = [])
    {
        
        $this->_attachProduct=$attachProduct;
        $this->_productCLP=$productCLP;
        parent::__construct($context, $data);
        
    }

    /**
     * Check available attachment and return collection
     */
    public function CheckAttachAvailable($id)
    {
        $model = $this->_attachProduct->getCollection()->addFieldToFilter("product_id", $id);
        $clp_id=array();
        foreach($model as $attach)
        {
            $clp_id[]=$attach['clp_id'];
        }
        $collection=$this->_productCLP->getCollection()
                    ->addFieldToFilter("astatus", "Enabled")
                    ->addFieldToFilter('clp_id', ['in' => $clp_id]);
        $collection->setOrder('sort_order', 'ASC');
        return $collection;
    }
}
