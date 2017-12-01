<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Block\Adminhtml\GiftCards;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'card_id';
        $this->_controller = 'adminhtml_giftCards';
        $this->_blockGroup = 'MageWorx_GiftCards';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Gift Card'));
        $this->setId('mageworx_giftcards_view');
    }

    /**
     * Retrieve currently edited giftcard object
     *
     * @return \MageWorx\GiftCards\Model\GiftCards
     */
    public function getGiftcard()
    {
        return $this->coreRegistry->registry('mageworx_current_giftcard');
    }

    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('mageworx_giftcards/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }

    /**
     * @return mixed
     */
    public function getGiftcardId()
    {
        return $this->getGiftcard()->getId();
    }

    /**
     * Retrieve header text
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->getGiftcard()->getId()) {
            $header = __('Edit Gift Card') . ' '  . $this->getGiftcard()->getCardCode();
        } else {
            $header = __('New Gift Card');
        }
        return $header;
    }
}
