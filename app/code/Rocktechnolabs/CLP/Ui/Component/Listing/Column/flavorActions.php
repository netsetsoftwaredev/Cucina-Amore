<?php
/**
 * @category Rocktechnolabs CLP
 * @package Rocktechnolabs_CLP
 * @copyright Copyright (c) 2017 Rocktechnolabs
 * @author Rocktechnolabs Team <support@rocktechnolabs.com>
 */
namespace Rocktechnolabs\CLP\Ui\Component\Listing\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

/**
 * Class flavorActions
 */
class flavorActions extends Column
{
    /** Url path */
    const SLIDE_URL_PATH_EDIT = 'clp/flavor/edit';
    const SLIDE_URL_PATH_DELETE = 'clp/flavor/delete';

    /** @var UrlInterface */
    protected $urlBuilder;

    /**
     * @param ContextInterface
     * @param UiComponentFactory
     * @param UrlInterface
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) 
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['flavor_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(self::SLIDE_URL_PATH_EDIT, ['flavor_id' => $item['flavor_id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::SLIDE_URL_PATH_DELETE, ['flavor_id' => $item['flavor_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete ${ $.$data.fname }'),
                            'message' => __('Are you sure you wan\'t to delete a ${ $.$data.fname } record?')
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}
