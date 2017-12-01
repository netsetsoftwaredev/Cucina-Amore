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
class Sec1 extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
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
        $fieldset = $form->addFieldset('top_fieldset', ['legend' => __('Top Section Information')]);

        if ($model->getId()) {
            $fieldset->addField('clp_id', 'hidden', ['name' => 'clp_id']);
        }

        $fieldset->addField('product_id', 'hidden', ['name' => 'product_id']);

        $fieldset->addField(
            '1bimage',
            'image',
            [
                'name' => '1bimage',
                'id' => '1bimage',
                'label' => __('Backgroung Image'),
                'title' => __('Backgroung Image'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => true
            ]
        );
        
        $fieldset->addField(
            '1title',
            'text',
            [
                'name' => '1title',
                'id' => '1title',
                'label' => __('Top Section Title'),
                'title' => __('Top Section Title'),
                'required' => true
            ]
        );

        $fieldset->addField(
            '1description',
            'editor',
            [
                'label' => __('Description '),
                'title' => __('Description'),
                'name' => '1description',
                'id' => '1description',
                'required' => true,
                'config' => $this->_wysiwygConfig->getConfig()
            ]
        );
        
        $fieldset->addField(
            '1shoplink',
            'text',
            [
                'name' => '1shoplink',
                'id' => '1shoplink',
                'label' => __('Shop Link'),
                'title' => __('Shop Link'),
                'required' => true
            ]
        );

        $fieldset->addField(
            '1buylink',
            'text',
            [
                'name' => '1buylink',
                'id' => '1buylink',
                'label' => __('Buy Link'),
                'title' => __('Buy Link'),
                'required' => true
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
        return __('Top Section');
    }

    /**
     * Prepare title for tab
     *
     * @return $string
     */
    public function getTabTitle()
    {
        return __('Top Section');
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
