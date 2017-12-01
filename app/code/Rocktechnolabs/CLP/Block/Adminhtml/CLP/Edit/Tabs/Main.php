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
        array $data = []
    ) 
    {
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
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('CLP Information')]);

        if ($model->getId()) {
            $fieldset->addField('clp_id', 'hidden', ['name' => 'clp_id']);
        }

        $fieldset->addField('product_id', 'hidden', ['name' => 'product_id']);

        $fieldset->addField(
            'ctitle',
            'text',
            [
                'name' => 'ctitle',
                'id' => 'ctitle',
                'label' => __('Page Title'),
                'title' => __('Page Title'),
                'required' => true,
                'after_element_html'=>'<small>Enter CLP Title.</small>'
            ]
        );
        
        $fieldset->addField(
            'clp_url',
            'text',
            [
                'label' => __('CLP Url'),
                'title' => __('CLP Url'),
                'name' => 'clp_url',
                'id' => 'clp_url',
                'required' => true,
            ]
        );
        
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    public function isFileRequired()
    {
        $model = $this->_coreRegistry->registry('clp_data');
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
        return __('Information');
    }

    /**
     * Prepare title for tab
     *
     * @return $string
     */
    public function getTabTitle()
    {
        return __('Information');
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
