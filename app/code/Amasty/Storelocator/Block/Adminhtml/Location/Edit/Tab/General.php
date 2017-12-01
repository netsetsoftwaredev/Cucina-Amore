<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_Storelocator
 */


namespace Amasty\Storelocator\Block\Adminhtml\Location\Edit\Tab;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

class General extends Generic implements TabInterface
{

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_store;

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    protected $_wysiwygConfig;

    /**
     * @var \Amasty\Storelocator\Helper\Data
     */
    protected $_helper;

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('General Information');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Location Settings');
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
        return false;
    }

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $store
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Amasty\Storelocator\Model\WysiwygConfig $wysiwygConfig,
        \Magento\Store\Model\System\Store $store,
        \Amasty\Storelocator\Helper\Data $helper,
        array $data = []
    ) {
        $this->_store = $store;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_helper = $helper;
        $this->_storeManager = $context->getStoreManager();
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return $this
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('current_amasty_storelocator_location');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('location_');

        $ObjectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('General')]);
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }

        $fieldset->addField(
            'name', 'text', [
                'label'    => __('Location name'),
                'required' => true,
                'name'     => 'name',
            ]
        );


        if (!$this->_storeManager->isSingleStoreMode()) {
            $fieldset->addField(
                'stores', 'multiselect', array(
                    'name'     => 'stores[]',
                    'label'    => __('Store View'),
                    'title'    => __('Store View'),
                    'required' => true,
                    'values'   => $this->_store->getStoreValuesForForm(false, true)
                )
            );
        } else {
            $fieldset->addField(
                'store_id', 'hidden', array(
                    'name'  => 'store_id[]',
                    'value' => $this->_storeManager->getStore(true)->getId()
                )
            );
        }

        $fieldset->addField('country', 'select', array(
                'name'  => 'country',
                'required' => true,
                'class'    => 'countries',
                'label'     => 'Country',
                'values'    => $ObjectManager->get('Magento\Config\Model\Config\Source\Locale\Country')->toOptionArray(),
            )
        );

        $fieldset->addField('state_id', 'select', array(
                'name'  => 'state_id',
                'label'     => 'State/Province',
            )
        );

        $fieldset->addField('state', 'text', array(
                'name'  => 'state',
                'label'     => 'State/Province',

            )
        );

        $fieldset->addField(
            'city', 'text', array(
                'label'    => __('City'),
                'required' => true,
                'name'     => 'city',
            )
        );

        $fieldset->addField(
            'description', 'editor', array(
                'label'    => __('Description'),
                'required' => true,
                'config'    => $this->_wysiwygConfig->getConfig(),
                'name'     => 'description',
            )
        );

        $fieldset->addField(
            'zip', 'text', array(
                'label'    => __('Zip'),
                'required' => true,
                'name'     => 'zip',
            )
        );

        $fieldset->addField(
            'address', 'text', array(
                'label'    => __('Address'),
                'required' => true,
                'name'     => 'address',
            )
        );

        $fieldset->addField(
            'phone', 'text', array(
                'label'    => __('Phone Number'),
                'name'     => 'phone',
            )
        );

        $fieldset->addField(
            'email', 'text', array(
                'label'    => __('E-mail Address'),
                'name'     => 'email',
            )
        );

        $fieldset->addField(
            'website', 'text', array(
                'label'    => __('Website URL'),
                'name'     => 'website',
            )
        );

        $fieldset->addField(
            'status', 'select', array(
                'label'    => __('Status'),
                'required' => true,
                'name'     => 'status',
                'values'   => array('1' => 'Enabled', '0' => 'Disabled'),
            )
        );

        $fieldset->addField(
            'position', 'text', array(
                'class'    => 'validate-number',
                'label'    => __('Position'),
                'required' => false,
                'name'     => 'position',
            )
        );

        $fieldset->addField('store_img', 'file', array(
            'label'     => __('Image'),
            'name'      => 'store_img',
            'after_element_html' => $this->getImageHtml('store_img', $model->getStoreImg()),
        ));

        $form->setValues($model->getData());
        $form->addValues(['id'=>$model->getId()]);
        $this->setForm($form);
        return parent::_prepareForm();
    }

    protected function getImageHtml($field, $img)
    {
        $html = '';
        if ($img) {
            $html .= '<p style="margin-top: 5px">';
            $html .= '<img style="max-width:100px" src="' . $this->_helper->getImageUrl($img) . '" />';
            $html .= '<br/><input type="checkbox" value="1" name="remove_' . $field . '"/> ' . __('Remove');
            $html .= '<input type="hidden" value="' . $img . '" name="old_' . $field . '"/>';
            $html .= '</p>';
        }
        return $html;
    }
}