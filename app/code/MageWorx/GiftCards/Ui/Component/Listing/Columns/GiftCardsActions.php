<?php
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class GiftCardsActions extends Column
{
    /** Url path */
    const GIFTCARDS_URL_PATH_EDIT = 'mageworx_giftcards/giftcards/edit';
    const GIFTCARDS_URL_PATH_STATISTIC = 'mageworx_giftcards/giftcards/statistic';
    const GIFTCARDS_URL_PATH_DELETE = 'mageworx_giftcards/giftcards/delete';
    const GIFTCARDS_URL_PATH_RESEND = 'mageworx_giftcards/giftcards/resend';
    const GIFTCARDS_URL_PATH_PRINT = 'mageworx_giftcards/giftcards/printCard';

    /** @var UrlInterface */
    protected $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return void
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(self::GIFTCARDS_URL_PATH_EDIT, ['card_id' => $item['card_id']]),
                        'label' => __('Edit'),
                        'hidden' => false,
                ];
                $item[$this->getData('name')]['statistic'] = [
                        'href' => $this->urlBuilder->getUrl(self::GIFTCARDS_URL_PATH_STATISTIC, ['card_id' => $item['card_id']]),
                        'label' => __('Statistic'),
                        'hidden' => false,
                ];
                $item[$this->getData('name')]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::GIFTCARDS_URL_PATH_DELETE, ['card_id' => $item['card_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete "${ $.$data.title }"'),
                            'message' => __('Are you sure you wan\'t to delete a "${ $.$data.title }" record?')
                        ]
                ];
                if ($item['card_type'] == \MageWorx\GiftCards\Model\GiftCards::TYPE_PRINT) {
                    $item[$this->getData('name')]['resend'] = [
                            'href' => $this->urlBuilder->getBaseUrl() . self::GIFTCARDS_URL_PATH_PRINT . '/giftcard_id/'.$item['card_id'],
                            'label' => __('Print'),
                            'hidden' => false,
                            'target' => '_blank',
                    ];
                } else {
                    $item[$this->getData('name')]['resend'] = [
                            'href' => $this->urlBuilder->getUrl(self::GIFTCARDS_URL_PATH_RESEND, ['card_id' => $item['card_id']]),
                            'label' => __('Resend'),
                            'hidden' => false,
                    ];
                }
            }
        }
        return $dataSource;
    }
}
