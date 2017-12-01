<?php
/**
 *
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Model;

use MageWorx\GiftCards\Api\Data\GiftftCardsOrderInterface;
use MageWorx\GiftCards\Model\ResourceModel\Order\Collection;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class OrderRepository implements \MageWorx\GiftCards\Api\GiftCardsOrderRepositoryInterface
{
    /**
     * @var GiftCardsOrderFactory
     */
    protected $giftCardsOrderFactory;

    /**
     * @var GiftCardOrders[]
     */
    protected $instances = [];

    /**
     * @var GiftCardOrders[]
     */
    protected $instancesByCardCode = [];

    /**
     * @var GiftCardOrders[]
     */
    protected $instancesByCardId = [];

    /**
     * @var GiftCardOrders[]
     */
    protected $instancesByOrderId = [];

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var \MageWorx\GiftCards\Model\ResourceModel\Order\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \MageWorx\GiftCards\Model\ResourceModel\Order
     */
    protected $resourceModel;

    /**
     * @var \MageWorx\GiftCards\Model\ResourceModel\GiftCards
     */
    protected $giftCardsResourceModel;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * GiftCardsOrderRepository constructor.
     * @param GiftCardsOrderFactory $giftCardsOrderFactory
     * @param ResourceModel\Order\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ResourceModel\Order $resourceModel
     * @param ResourceModel\GiftCards $giftCardsResouprceModel
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(
        OrderFactory $giftCardsOrderFactory,
        \MageWorx\GiftCards\Model\ResourceModel\Order\CollectionFactory $collectionFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \MageWorx\GiftCards\Model\ResourceModel\Order $resourceModel,
        \MageWorx\GiftCards\Model\ResourceModel\GiftCards $giftCardsResourceModel,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Api\FilterBuilder $filterBuilder
    ) {
        $this->giftCardsOrderFactory = $giftCardsOrderFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->resourceModel = $resourceModel;
        $this->giftCardsResourceModel = $giftCardsResourceModel;
        $this->storeManager = $storeManager;
        $this->filterBuilder = $filterBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getByGiftCardCode($giftCardCode, $editMode = false, $storeId = null, $forceReload = false)
    {
        $cacheKey = $this->getCacheKey([$editMode, $storeId]);
        if (!isset($this->instancesByCardCode[$giftCardCode][$cacheKey]) || $forceReload) {
            $giftCardOrder = $this->giftCardsOrderFactory->create();

            $giftCardId = $this->giftCardsResourceModel->getIdByCardCode($giftCardCode);
            $giftCardOrderId = $this->resourceModel->getIdByCardId($giftCardId);
            if (!$giftCardOrderId) {
                throw new NoSuchEntityException(__('Requested Order for Gift Card %1 doesn\'t exist', $giftCardCode));
            }
            if ($editMode) {
                $giftCardOrder->setData('_edit_mode', true);
            }
            $giftCardOrder->load($giftCardOrderId);
            $this->instancesByCardCode[$giftCardCode][$cacheKey] = $giftCardOrder;
            $this->instancesByCardId[$giftCardId][$cacheKey] = $giftCardOrder;
            $this->instancesByOrderId[$giftCardOrder->getOrderId()][$cacheKey] = $giftCardOrder;
            $this->instances[$giftCardOrderId][$cacheKey] = $giftCardOrder;
        }
        return $this->instancesByCardCode[$giftCardCode][$cacheKey];
    }

    /**
     * {@inheritdoc}
     */
    public function getByGiftCardId($giftCardId, $editMode = false, $storeId = null, $forceReload = false)
    {
        $cacheKey = $this->getCacheKey([$editMode, $storeId]);
        if (!isset($this->instancesByCardId[$giftCardId][$cacheKey]) || $forceReload) {
            $giftCardOrder = $this->giftCardsOrderFactory->create();

            $giftCardOrderId = $this->resourceModel->getIdByCardId($giftCardId);
            if (!$giftCardOrderId) {
                throw new NoSuchEntityException(__('Requested Order for Gift Card %1 doesn\'t exist', $giftCardCode));
            }
            if ($editMode) {
                $giftCardOrder->setData('_edit_mode', true);
            }
            $giftCardOrder->load($giftCardOrderId);
            $this->instancesByCardId[$giftCardId][$cacheKey] = $giftCardOrder;
            $this->instancesByOrderId[$giftCardOrder->getOrderId()][$cacheKey] = $giftCardOrder;
            $this->instances[$giftCardOrderId][$cacheKey] = $giftCardOrder;
        }
        return $this->instancesByCardId[$giftCardId][$cacheKey];
    }

    /**
     * {@inheritdoc}
     */
    public function getByOrderId($orderId, $editMode = false, $storeId = null, $forceReload = false)
    {
        $cacheKey = $this->getCacheKey([$editMode, $storeId]);
        if (!isset($this->instancesByOrderId[$orderId][$cacheKey]) || $forceReload) {
            $giftCardOrder = $this->giftCardsOrderFactory->create();

            $giftCardOrderId = $this->resourceModel->getIdByOrderId($orderId);
            if (!$giftCardOrderId) {
                throw new NoSuchEntityException(__('Requested Order doesn\'t exist'));
            }
            if ($editMode) {
                $giftCardOrder->setData('_edit_mode', true);
            }
            $giftCardOrder->load($giftCardOrderId);
            $this->instancesByOrderId[$orderId][$cacheKey] = $giftCardOrder;
            $this->instancesByCardId[$giftCardId][$cacheKey] = $giftCardOrder;
            $this->instances[$giftCardOrderId][$cacheKey] = $giftCardOrder;
        }
        return $this->instancesByOrderId[$orderId][$cacheKey];
    }

    /**
     * {@inheritdoc}
     */
    public function get($id, $editMode = false, $storeId = null, $forceReload = false)
    {
        $cacheKey = $this->getCacheKey([$editMode, $storeId]);
        if (!isset($this->instances[$id][$cacheKey]) || $forceReload) {
            $giftCardOrder = $this->giftCardsOrderFactory->create();
            if ($editMode) {
                $giftCardOrder->setData('_edit_mode', true);
            }
            $giftCardOrder->load($id);
            if (!$giftCardOrder->getId()) {
                throw new NoSuchEntityException(__('Requested Gift Card Order doesn\'t exist'));
            }
            $this->instances[$id][$cacheKey] = $giftCardOrder;
            $this->instancesByCardId[$giftCardOrder->getCardId()][$cacheKey] = $giftCardOrder;
            $this->instancesByOrderId[$giftCardOrder->getOrderId()][$cacheKey] = $giftCardOrder;
        }
        return $this->instances[$id][$cacheKey];
    }

    /**
     * Get key for cache
     *
     * @param array $data
     * @return string
     */
    protected function getCacheKey($data)
    {
        $serializeData = [];
        foreach ($data as $key => $value) {
            if (is_object($value)) {
                $serializeData[$key] = $value->getId();
            } else {
                $serializeData[$key] = $value;
            }
        }

        return md5(serialize($serializeData));
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function save(\MageWorx\GiftCards\Api\Data\GiftCardsOrderInterface $giftCardOrder, $saveOptions = false)
    {
        try {
            unset($this->instances[$giftCardOrder->getId()]);
            unset($this->instancesByCardId[$giftCardOrder->getCardId()]);
            unset($this->instancesByOrderId[$giftCardOrder->getOrderId()]);
            $this->resourceModel->save($giftCardOrder);
        } catch (\Magento\Eav\Model\Entity\Attribute\Exception $exception) {
            throw \Magento\Framework\Exception\InputException::invalidFieldValue(
                $exception->getAttributeCode(),
                $giftCardOrder->getData($exception->getAttributeCode()),
                $exception
            );
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (LocalizedException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__('Unable to save Gift Card Order'));
        }
        unset($this->instances[$giftCardOrder->getId()]);
        unset($this->instancesByCardId[$giftCardOrder->getCardId()]);
        unset($this->instancesByOrderId[$giftCardOrder->getOrderId()]);
        return $this->get($giftCardOrder->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(\MageWorx\GiftCards\Api\Data\GiftCardsOrderInterface $giftCardOrder)
    {
        $giftCardOrderId = $giftCardOrder->getId();
        $cardId          = $giftCardOrder->getCardId();
        $orderId         = $giftCardOrder->getOrderId();
        try {
            unset($this->instances[$giftCardOrder->getId()]);
            unset($this->instancesByCardId[$giftCardOrder->getCardId()]);
            unset($this->instancesByOrderId[$giftCardOrder->getOrderId()]);
            $this->resourceModel->delete($giftCardOrder);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\StateException(
                __('Unable to remove Gift Card Order')
            );
        }
        unset($this->instances[$giftCardOrderId]);
        unset($this->instancesByCardId[$cardId]);
        unset($this->instancesByOrderId[$orderId]);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($giftCardOrderId)
    {
        $giftCardOrder = $this->get($giftCardOrderId);
        return $this->delete($giftCardOrder);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteByGiftCardId($giftCardId)
    {
        $giftCardOrder = $this->getByGiftCardId($giftCardId);
        return $this->delete($giftCardOrder);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteByOrderId($orderId)
    {
        $giftCardOrder = $this->getByOrderId($orderId);
        return $this->delete($giftCardOrder);
    }
    
    /**
     * {@inheritdoc}
     */
    public function deleteByGiftCardCode($giftCardCode)
    {
        $giftCardOrder = $this->getByGiftCardCode($giftCardCode);
        return $this->delete($giftCardOrder);
    }

    /**
     * Clean internal product cache
     *
     * @return void
     */
    public function cleanCache()
    {
        $this->instances = null;
        $this->instancesById = null;
    }
}
