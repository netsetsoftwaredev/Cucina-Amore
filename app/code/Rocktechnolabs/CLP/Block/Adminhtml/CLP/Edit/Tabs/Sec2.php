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
class Sec2 extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
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
        $fieldset = $form->addFieldset('second_fieldset', ['legend' => __('How, What and Where Information')]);

        if ($model->getId()) {
            $fieldset->addField('clp_id', 'hidden', ['name' => 'clp_id']);
        }

        $fieldset->addField('product_id', 'hidden', ['name' => 'product_id']);

        $fieldset->addField(
            '2title',
            'text',
            [
                'name' => '2title',
                'id' => '2title',
                'label' => __('Section Title'),
                'title' => __('Section Title'),
                'required' => true
            ]
        );

        $fieldset->addField(
            '2description',
            'editor',
            [
                'label' => __('Section Description '),
                'title' => __('Section Description'),
                'name' => '2description',
                'id' => '2description',
                'required' => true,
                'config' => $this->_wysiwygConfig->getConfig()
            ]
        );

        $fieldset->addField(
            '2hwbimage1',
            'image',
            [
                'name' => '2hwbimage1',
                'id' => '2hwbimage1',
                'label' => __('How Background Image_1'),
                'title' => __('How Background Image_1'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => true
            ]
        );

        $fieldset->addField(
            '2hwimage1',
            'image',
            [
                'name' => '2hwimage1',
                'id' => '2hwimage1',
                'label' => __('How Image_1'),
                'title' => __('How Image_1'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => true
            ]
        );
        
        $fieldset->addField(
            '2hwcontent1',
            'editor',
            [
                'label' => __('How Content_1'),
                'title' => __('How Content_1'),
                'name' => '2hwcontent1',
                'id' => '2hwcontent1',
                'required' => true,
                'config' => $this->_wysiwygConfig->getConfig()
            ]
        );
        
        $fieldset->addField(
            '2hwbimage2',
            'image',
            [
                'name' => '2hwbimage2',
                'id' => '2hwbimage2',
                'label' => __('How Background Image_2'),
                'title' => __('How Background Image_2'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => false
            ]
        );

        $fieldset->addField(
            '2hwimage2',
            'image',
            [
                'name' => '2hwimage2',
                'id' => '2hwimage2',
                'label' => __('How Image_2'),
                'title' => __('How Image_2'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => false
            ]
        );
        
        $fieldset->addField(
            '2hwcontent2',
            'editor',
            [
                'label' => __('How Content_2'),
                'title' => __('How Content_2'),
                'name' => '2hwcontent2',
                'id' => '2hwcontent2',
                'required' => false,
                'config' => $this->_wysiwygConfig->getConfig()
            ]
        );

       /* $fieldset->addField(
            '2wtbimage1',
            'image',
            [
                'name' => '2wtbimage1',
                'id' => '2wtbimage1',
                'label' => __('What Background Image_1'),
                'title' => __('What Background Image_1'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => true
            ]
        );*/

         $fieldset->addField(
            '2wtbimage1',
            'image',
            [
                'name' => '2wtbimage1',
                'id' => '2wtbimage1',
                'label' => __('What Background Image_1'),
                'title' => __('What Background Image_1'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => true
            ]
        );

        $fieldset->addField(
            '2wtimage1',
            'image',
            [
                'name' => '2wtimage1',
                'id' => '2wtimage1',
                'label' => __('What Image_1'),
                'title' => __('What Image_1'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => true
            ]
        );
        
        $fieldset->addField(
            '2wtcontent1',
            'editor',
            [
                'label' => __('What Content_1'),
                'title' => __('What Content_1'),
                'name' => '2wtcontent1',
                'id' => '2wtcontent1',
                'required' => true,
                'config' => $this->_wysiwygConfig->getConfig()
            ]
        );

       /* $fieldset->addField(
            '2wtbimage2',
            'image',
            [
                'name' => '2wtbimage2',
                'id' => '2wtbimage2',
                'label' => __('What Background Image_2'),
                'title' => __('What Background Image_2'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => false
            ]
        );*/

        $fieldset->addField(
            '2wtimage2',
            'image',
            [
                'name' => '2wtimage2',
                'id' => '2wtimage2',
                'label' => __('What Image_2'),
                'title' => __('What Image_2'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => false
            ]
        );
        
        $fieldset->addField(
            '2wtcontent2',
            'editor',
            [
                'label' => __('What Content_2'),
                'title' => __('What Content_2'),
                'name' => '2wtcontent2',
                'id' => '2wtcontent2',
                'required' => false,
                'config' => $this->_wysiwygConfig->getConfig()
            ]
        );

        $fieldset->addField(
            '2webimage1',
            'image',
            [
                'name' => '2webimage1',
                'id' => '2webimage1',
                'label' => __('Where Background Image_1'),
                'title' => __('Where Image_1'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => true
            ]
        );

        $fieldset->addField(
            '2weimage1',
            'image',
            [
                'name' => '2weimage1',
                'id' => '2weimage1',
                'label' => __('Where Image_1'),
                'title' => __('Where Image_1'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => true
            ]
        );
        
        $fieldset->addField(
            '2wecontent1',
            'editor',
            [
                'label' => __('Where Content_1'),
                'title' => __('Where Content_1'),
                'name' => '2wecontent1',
                'id' => '2wecontent1',
                'required' => true,
                'config' => $this->_wysiwygConfig->getConfig()
            ]
        );

        $fieldset->addField(
            '2webimage2',
            'image',
            [
                'name' => '2webimage2',
                'id' => '2webimage2',
                'label' => __('Where Background Image_2'),
                'title' => __('Where Background Image_2'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => false
            ]
        );

        $fieldset->addField(
            '2weimage2',
            'image',
            [
                'name' => '2weimage2',
                'id' => '2weimage2',
                'label' => __('Where Image_2'),
                'title' => __('Where Image_2'),
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => false
            ]
        );
        
        $fieldset->addField(
            '2wecontent2',
            'editor',
            [
                'label' => __('Where Content_2'),
                'title' => __('Where Content_2'),
                'name' => '2wecontent2',
                'id' => '2wecontent2',
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
        return __('How,What and Where');
    }

    /**
     * Prepare title for tab
     *
     * @return $string
     */
    public function getTabTitle()
    {
        return __('How,What and Where');
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
