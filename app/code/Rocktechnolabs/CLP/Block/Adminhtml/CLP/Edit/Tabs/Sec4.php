<?php
/**
 * @category Rocktechnolabs CLP
 * @package Rocktechnolabs_CLP
 * @copyright Copyright (c) 2017 Rocktechnolabs
 * @author Rocktechnolabs Team <support@rocktechnolabs.com>
 */
namespace Rocktechnolabs\CLP\Block\Adminhtml\CLP\Edit\Tabs;

/**
 * CLP Main tab
 */
class Sec4 extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    protected $_nitritionicon;
    /**
     * @param \Magento\Backend\Block\Template\Context 
     * @param \Magento\Framework\Registry 
     * @param \Magento\Framework\Data\FormFactory
     * @param array
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Rocktechnolabs\CLP\Model\Source\NitritionIcon $nitritionicon,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        array $data = []
    ) 
    {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_nitritionicon=$nitritionicon;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */ 
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('clp_data');
        $isElementDisabled = false;
        $form = $this->_formFactory->create(
            ['data' => [
                            'id' => 'edit_form', 
                            'enctype' => 'multipart/form-data', 
                            'action' => $this->getData('action'), 
                            'method' => 'POST'
                        ]
            ]
        );
        $fieldset = $form->addFieldset('fourth_fieldset', ['legend' => __('NUTRITION Information')]);

        if ($model->getId()) {
            $fieldset->addField('clp_id', 'hidden', ['name' => 'clp_id']);
        }

        $fieldset->addField('product_id', 'hidden', ['name' => 'product_id']);

        $optionArray = $this->_nitritionicon->toOptionArray();
        $field = $fieldset->addField(
            '4nutritionicon',
            'multiselect',
            [
                'label' => __('NUTRITION Icon'),
                'required' => true,
                'name' => '4nutritionicon',
                'values' => $optionArray,
            ]
        );

        $fieldset->addField(
            '4nutritionfact',
            'image',
            [
                'name' => '4nutritionfact',
                'id' => '4nutritionfact',
                'label' => __('NUTRITION Fact Image'),
                'title' => __('NUTRITION Fact Image'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => true
            ]
        );

        $fieldset->addField(
            '4nutritiontitle',
            'text',
            [
                'name' => '4nutritiontitle',
                'id' => '4nutritiontitle',
                'label' => __('NUTRITION Title'),
                'title' => __('NUTRITION Title'),
                'required' => true
            ]
        );

        $fieldset->addField(
            '4nutritiondesc',
            'editor',
            [
                'label' => __('NUTRITION Description '),
                'title' => __('NUTRITION Description'),
                'name' => '4nutritiondesc',
                'id' => '4nutritiondesc',
                'required' => true,
                'config' => $this->_wysiwygConfig->getConfig()
            ]
        );

        $fieldset->addField(
            '4nutritionimage',
            'image',
            [
                'name' => '4nutritionimage',
                'id' => '4nutritionimage',
                'label' => __('NUTRITION Image'),
                'title' => __('NUTRITION Image'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => true
            ]
        );

        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Get tab Label
     *
     * @return $string
     */ 
    public function getTabLabel()
    {
        return __('NUTRITION Info');
    }

    /**
     * Prepare title for tab
     *
     * @return $string
     */
    public function getTabTitle()
    {
        return __('NUTRITION Info');
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
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
