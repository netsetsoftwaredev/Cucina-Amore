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
class Sec3 extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
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
        $fieldset = $form->addFieldset('third_fieldset', ['legend' => __('CUCINA & Your Life Information')]);

        if ($model->getId()) {
            $fieldset->addField('clp_id', 'hidden', ['name' => 'clp_id']);
        }

        $fieldset->addField('product_id', 'hidden', ['name' => 'product_id']);

        $fieldset->addField(
            '3title1',
            'text',
            [
                'name' => '3title1',
                'id' => '3title1',
                'label' => __('Top Title'),
                'title' => __('Top Title'),
                'required' => true
            ]
        );

        $fieldset->addField(
            '3description1',
            'editor',
            [
                'label' => __('Top Description '),
                'title' => __('Top Description'),
                'name' => '3description1',
                'id' => '3description1',
                'required' => true,
                'config' => $this->_wysiwygConfig->getConfig()
            ]
        );

        $fieldset->addField(
            '3title2',
            'text',
            [
                'name' => '3title2',
                'id' => '3title2',
                'label' => __('Title for Healthy'),
                'title' => __('Title for Healthy'),
                'required' => true
            ]
        );

        $fieldset->addField(
            '3description2',
            'editor',
            [
                'label' => __('Description for Healthy '),
                'title' => __('Description for Healthy'),
                'name' => '3description2',
                'id' => '3description2',
                'required' => true,
                'config' => $this->_wysiwygConfig->getConfig()
            ]
        );

        $fieldset->addField(
            '3bimage2',
            'image',
            [
                'name' => '3bimage2',
                'id' => '3bimage2',
                'label' => __('Healthy Background Image'),
                'title' => __('Healthy Background Image'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => true
            ]
        );

        $fieldset->addField(
            '3image31',
            'image',
            [
                'name' => '3image31',
                'id' => '3image31',
                'label' => __('Healthy Image_1'),
                'title' => __('Healthy Image_1'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => true
            ]
        );

        $fieldset->addField(
            '3image32',
            'image',
            [
                'name' => '3image32',
                'id' => '3image32',
                'label' => __('Healthy Image_2'),
                'title' => __('Healthy Image_2'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => true
            ]
        );
        
        $fieldset->addField(
            '3description3',
            'editor',
            [
                'label' => __('Healthy Description'),
                'title' => __('Healthy Description'),
                'name' => '3description3',
                'id' => '3description3',
                'required' => true,
                'config' => $this->_wysiwygConfig->getConfig()
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
        return __('CUCINA & Your Life');
    }

    /**
     * Prepare title for tab
     *
     * @return $string
     */
    public function getTabTitle()
    {
        return __('CUCINA & Your Life');
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
