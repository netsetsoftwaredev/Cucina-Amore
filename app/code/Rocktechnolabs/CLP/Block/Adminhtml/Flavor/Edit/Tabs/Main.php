<?php
/**
 * @category Rocktechnolabs CLP
 * @package Rocktechnolabs_CLP
 * @copyright Copyright (c) 2017 Rocktechnolabs
 * @author Rocktechnolabs Team <support@rocktechnolabs.com>
 */
namespace Rocktechnolabs\CLP\Block\Adminhtml\Flavor\Edit\Tabs;

/**
 * CLP Main tab
 */
class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
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
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        array $data = []
    ) 
    {
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */ 
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('flavor_data');
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
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Flavor Information')]);

        if ($model->getId()) {
            $fieldset->addField('flavor_id', 'hidden', ['name' => 'flavor_id']);
        }

        $fieldset->addField('product_id', 'hidden', ['name' => 'product_id']);

        $fieldset->addField(
            'fname',
            'text',
            [
                'name' => 'fname',
                'id' => 'fname',
                'label' => __('Flavor Name'),
                'title' => __('Flavor Name'),
                'required' => true,
                'after_element_html'=>'<small>Enter Flavor Name.</small>'
            ]
        );
        
        $fieldset->addField(
            'fdescription',
            'editor',
            [
                'label' => __('Flavor Description '),
                'title' => __('Flavor Description'),
                'name' => 'fdescription',
                'id' => 'fdescription',
                'required' => false,
                'config' => $this->_wysiwygConfig->getConfig()
            ]
        );
        
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    public function isFileRequired()
    {
        $model = $this->_coreRegistry->registry('flavor_data');
        if(empty($model->getData('file')))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    /**
     * Get tab Label
     *
     * @return $string
     */ 
    public function getTabLabel()
    {
        return __('Flavor Information');
    }

    /**
     * Prepare title for tab
     *
     * @return $string
     */
    public function getTabTitle()
    {
        return __('Flavor Information');
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
