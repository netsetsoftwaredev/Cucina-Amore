<?php
namespace WTC\Career\Block\Adminhtml\Career;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \WTC\Career\Model\careerFactory
     */
    protected $_careerFactory;

    /**
     * @var \WTC\Career\Model\Status
     */
    protected $_status;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \WTC\Career\Model\careerFactory $careerFactory
     * @param \WTC\Career\Model\Status $status
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \WTC\Career\Model\CareerFactory $CareerFactory,
        \WTC\Career\Model\Status $status,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
        $this->_careerFactory = $CareerFactory;
        $this->_status = $status;
        $this->moduleManager = $moduleManager;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('postGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);
        $this->setVarNameFilter('post_filter');
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_careerFactory->create()->getCollection();
        $this->setCollection($collection);

        parent::_prepareCollection();

        return $this;
    }

    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );


		
				$this->addColumn(
					'title',
					[
						'header' => __('Title'),
						'index' => 'title',
					]
				);
				
				$this->addColumn(
					'location',
					[
						'header' => __('Location'),
						'index' => 'location',
					]
				);
				
						
						$this->addColumn(
							'category',
							[
								'header' => __('Category'),
								'index' => 'category',
								'type' => 'options',
								'options' => \WTC\Career\Block\Adminhtml\Career\Grid::getOptionArray2()
							]
						);
						
						
				$this->addColumn(
					'position',
					[
						'header' => __('Position'),
						'index' => 'position',
					]
				);
				
				/* $this->addColumn(
					'created_at',
					[
						'header' => __('Created At'),
						'index' => 'created_at',
						'type'      => 'datetime',
					]
				); */
					
					
				$this->addColumn(
					'url',
					[
						'header' => __('Url'),
						'index' => 'url',
					]
				);
				
						
						$this->addColumn(
							'is_active',
							[
								'header' => __('Is Active'),
								'index' => 'is_active',
								'type' => 'options',
								'options' => \WTC\Career\Block\Adminhtml\Career\Grid::getOptionArray8()
							]
						);
						
						


		
        //$this->addColumn(
            //'edit',
            //[
                //'header' => __('Edit'),
                //'type' => 'action',
                //'getter' => 'getId',
                //'actions' => [
                    //[
                        //'caption' => __('Edit'),
                        //'url' => [
                            //'base' => '*/*/edit'
                        //],
                        //'field' => 'id'
                    //]
                //],
                //'filter' => false,
                //'sortable' => false,
                //'index' => 'stores',
                //'header_css_class' => 'col-action',
                //'column_css_class' => 'col-action'
            //]
        //);
		

		
		   $this->addExportType($this->getUrl('career/*/exportCsv', ['_current' => true]),__('CSV'));
		   $this->addExportType($this->getUrl('career/*/exportExcel', ['_current' => true]),__('Excel XML'));

        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }

        return parent::_prepareColumns();
    }

	
    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {

        $this->setMassactionIdField('id');
        //$this->getMassactionBlock()->setTemplate('WTC_Career::career/grid/massaction_extended.phtml');
        $this->getMassactionBlock()->setFormFieldName('career');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('career/*/massDelete'),
                'confirm' => __('Are you sure?')
            ]
        );

        $statuses = $this->_status->getOptionArray();

        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('career/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => __('Status'),
                        'values' => $statuses
                    ]
                ]
            ]
        );


        return $this;
    }
		

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('career/*/index', ['_current' => true]);
    }

    /**
     * @param \WTC\Career\Model\career|\Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
		
        return $this->getUrl(
            'career/*/edit',
            ['id' => $row->getId()]
        );
		
    }

	
		static public function getOptionArray2()
		{
            $data_array=array(); 
			$data_array['Corporate']='Corporate';
			$data_array['Marketing']='Marketing';
			$data_array['R&D']='R&D';
			$data_array['Sales']='Sales';
			$data_array['Warehouse']='Warehouse';
			$data_array['Transportation']='Transportation';
            return($data_array);
		}
		
		static public function getValueArray2()
		{
            $data_array=array();
			foreach(\WTC\Career\Block\Adminhtml\Career\Grid::getOptionArray2() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray8()
		{
            $data_array=array(); 
			$data_array[1]='Yes';
			$data_array[0]='No';
            return($data_array);
		}
		static public function getValueArray8()
		{
            $data_array=array();
			foreach(\WTC\Career\Block\Adminhtml\Career\Grid::getOptionArray8() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}