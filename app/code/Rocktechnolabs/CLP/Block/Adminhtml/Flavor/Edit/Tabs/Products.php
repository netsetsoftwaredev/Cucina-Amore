<?php
/**
 * @category Rocktechnolabs CLP
 * @package Rocktechnolabs_CLP
 * @copyright Copyright (c) 2017 Rocktechnolabs
 * @author Rocktechnolabs Team <support@rocktechnolabs.com>
 */
namespace Rocktechnolabs\CLP\Block\Adminhtml\Flavor\Edit\Tabs;
use Rocktechnolabs\CLP\Model\FlavorFactory; 

/**
 * CLP Product tab
 */
class Products extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Current productCollectionFactory
     *
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productCollectionFactory;
    
    /**
     * Manage Store Factory
     *
     * @var \Rocktechnolabs\StoreLocator\Model\FlavorFactory
     */
    protected $FlavorFactory;
    
    /**
     * Product Model Type
     *
     * @var \Magento\Catalog\Model\Product\Type
     */
    protected $_type;
    
    /**
     * product attribute status
     *
     * @var \Magento\Catalog\Model\Product\Attribute\Source\Status
     */
    protected $_status;
    
    /**
     * Model product Visibility
     *
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    protected $_visibility;
    
    /**
     * @param \Magento\Backend\Block\Template\Context 
     * @param \Magento\Backend\Helper\Data
     * @param \Magento\Framework\ObjectManagerInterface
     * @param \Rocktechnolabs\StoreLocator\Model\FlavorFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     * @param \Magento\Catalog\Model\Product\Type
     * @param \Magento\Catalog\Model\Product\Attribute\Source\Status
     * @param \Magento\Catalog\Model\Product\Visibility
     * @param array
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        FlavorFactory $FlavorFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Type $type,
        \Magento\Catalog\Model\Product\Attribute\Source\Status $status,
        \Magento\Catalog\Model\Product\Visibility $visibility,
        array $data = []
    ) 
    {
        $this->FlavorFactory = $FlavorFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->_type = $type;
        $this->_status = $status;
        $this->_visibility = $visibility;
        parent::__construct($context, $backendHelper, $data);
    }
    
    /**
     * Prepare construct
     *
     */ 
    protected function _construct()
    {
        parent::_construct();
        $this->setId('productsGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        if ($this->getRequest()->getParam('id')) {
            $this->setDefaultFilter(array('in_product' => 1));
        }
    }
    
    /**
     * Prepare Column to Filter
     *
     * @return $this
     */ 
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_product') {
            $productIds = $this->_getSelectedProducts();

            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in' => $productIds));
            } else {
                if ($productIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('in' => $productIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * Prepare Collection
     *
     * @return _parentCollection
     */ 
    protected function _prepareCollection()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        
        $collection->joinField(
            'qty', 'cataloginventory_stock_item', 'qty', 'product_id=entity_id', '{{table}}.stock_id=1', 'left'
        );
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_product',
            [
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'in_product',
                'align' => 'center',
                'index' => 'entity_id',
                'values' => $this->_getSelectedProducts(),
            ]
        );

        $this->addColumn(
            'entity_id',
            [
                'header' => __('Product ID'),
                'type' => 'number',
                'index' => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
                'width' => '10px',
            ]
        );

        $this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'index' => 'name',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );

        $this->addColumn(
            'sku',
            [
                'header' => __('Sku'),
                'index' => 'sku',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );

        $this->addColumn(
            'price',
            [
                'header' => __('Price'),
                'type' => 'currency',
                'index' => 'price',
                'width' => '50px',
            ]
        );
        
        $this->addColumn(
            'visibility',
            [
                'header' => __('Visibility'),
                'index' => 'visibility',
                'type' => 'options',
                'options' => $this->_visibility->getOptionArray(),
                'header_css_class' => 'col-visibility',
                'column_css_class' => 'col-visibility',
                'width' => '50px',
            ]
        );

        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'type' => 'options',
                'options' => $this->_status->getOptionArray(),
                'header_css_class' => 'col-status',
                'column_css_class' => 'col-status',
                'width' => '50px',
            ]
        );

        $this->addColumn(
            'type',
            [
                'header' => __('Type'),
                'index' => 'type_id',
                'type' => 'options',
                'options' => $this->_type->getOptionArray(),
                'header_css_class' => 'col-type',
                'column_css_class' => 'col-type',
                'width' => '50px',
            ]
        );
        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('clp/flavor/productsgrid', ['_current' => true]);
    }

    /**
     * @param  object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return '';
    }

    protected function _getSelectedProducts()
    {
        $allstore = $this->getAllAttach();
        return $allstore->getProducts($allstore);
    }

    /**
     * Retrieve selected products
     *
     * @return array
     */
    public function getSelectedProducts()
    {
        $allstore = $this->getAllAttach();
        $selected = $allstore->getProducts($allstore);
        if (!is_array($selected)) {
            $selected = [];
        }
        return $selected; 
    }

    protected function getAllAttach()
    {
        $allstoreId = $this->getRequest()->getParam('flavor_id');
        $allstore   = $this->FlavorFactory->create();
        if ($allstoreId) {
            $allstore->load($allstoreId);
        }
        return $allstore;
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return true;
    }
}
