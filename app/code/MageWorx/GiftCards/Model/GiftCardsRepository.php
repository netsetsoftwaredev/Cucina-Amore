<?php
/**
 *
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace MageWorx\GiftCards\Model;

use MageWorx\GiftCards\Api\Data\GiftCardsInterface;
use MageWorx\GiftCards\Model\ResourceModel\GiftCards\Collection;
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
class GiftCardsRepository implements \MageWorx\GiftCards\Api\GiftCardsRepositoryInterface
{
    /**
     * @var GiftCardsFactory
     */
    protected $giftCardsFactory;

    /**
     * @var GiftCards[]
     */
    protected $instances = [];

    /**
     * @var GiftCards[]
     */
    protected $instancesByCode = [];

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var \MageWorx\GiftCards\Model\ResourceModel\GiftCards\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \MageWorx\GiftCards\Model\ResourceModel\GiftCards
     */
    protected $resourceModel;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * GiftCardsRepository constructor.
     * @param GiftCardsFactory $giftCardsFactory
     * @param ResourceModel\GiftCards\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ResourceModel\GiftCards $resourceModel
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(
        GiftCardsFactory $giftCardsFactory,
        \MageWorx\GiftCards\Model\ResourceModel\GiftCards\CollectionFactory $collectionFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \MageWorx\GiftCards\Model\ResourceModel\GiftCards $resourceModel,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Api\FilterBuilder $filterBuilder
    ) {
        $this->giftCardsFactory = $giftCardsFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->resourceModel = $resourceModel;
        $this->storeManager = $storeManager;
        $this->filterBuilder = $filterBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getByCode($giftCardCode, $editMode = false, $storeId = null, $forceReload = false)
    {
        $cacheKey = $this->getCacheKey([$editMode, $storeId]);
        if (!isset($this->instancesByCode[$giftCardCode][$cacheKey]) || $forceReload) {
            $giftCard = $this->giftCardsFactory->create();

            $giftCardId = $this->resourceModel->getIdByCardCode($giftCardCode);
            if (!$giftCardId) {
                throw new NoSuchEntityException(__('Requested Gift Card doesn\'t exist'));
            }
            if ($editMode) {
                $giftCard->setData('_edit_mode', true);
            }
            $giftCard->load($giftCardId);
            $this->instancesByCode[$giftCardCode][$cacheKey] = $giftCard;
            $this->instances[$giftCardId][$cacheKey] = $giftCard;
        }
        return $this->instancesByCode[$giftCardCode][$cacheKey];
    }

    /**
     * {@inheritdoc}
     */
    public function get($giftCardId, $editMode = false, $storeId = null, $forceReload = false)
    {
        $cacheKey = $this->getCacheKey([$editMode, $storeId]);
        if (!isset($this->instances[$giftCardId][$cacheKey]) || $forceReload) {
            $giftCard = $this->giftCardsFactory->create();
            if ($editMode) {
                $giftCard->setData('_edit_mode', true);
            }
            $giftCard->load($giftCardId);
            if (!$giftCard->getId()) {
                throw new NoSuchEntityException(__('Requested Gift Card doesn\'t exist'));
            }
            $this->instances[$giftCardId][$cacheKey] = $giftCard;
            $this->instancesByCode[$giftCard->getCardCode()][$cacheKey] = $giftCard;
        }
        return $this->instances[$giftCardId][$cacheKey];
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
    public function save(\MageWorx\GiftCards\Api\Data\GiftCardsInterface $giftCard, $saveOptions = false)
    {
        try {
            unset($this->instances[$giftCard->getId()]);
            unset($this->instancesByCode[$giftCard->getCardCode()]);
            $this->resourceModel->save($giftCard);
        } catch (\Magento\Eav\Model\Entity\Attribute\Exception $exception) {
            throw \Magento\Framework\Exception\InputException::invalidFieldValue(
                $exception->getAttributeCode(),
                $giftCard->getData($exception->getAttributeCode()),
                $exception
            );
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (LocalizedException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__('Unable to save Gift Card'));
        }

        unset($this->instances[$giftCard->getId()]);
        unset($this->instancesByCode[$giftCard->getCardCode()]);

        if (!$giftCard->getId()) {
            return;
        } else {
            return $this->get($giftCard->getId());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete(\MageWorx\GiftCards\Api\Data\GiftCardsInterface $giftCard)
    {
        $cardCode = $giftCard->getCardCode();
        $cardId   = $giftCard->getId();
        try {
            unset($this->instances[$giftCard->getId()]);
            unset($this->instancesByCode[$giftCard->getCardCode()]);
            $this->resourceModel->delete($giftCard);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\StateException(
                __('Unable to remove Gift Card %1', $cardCode)
            );
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($giftCardId)
    {
        $giftCard = $this->get($giftCardId);
        return $this->delete($giftCard);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteByCode($giftCardCode)
    {
        $giftCard = $this->getByCode($giftCardCode);
        return $this->delete($giftCard);
    }

    /**
     * Clean internal product cache
     *
     * @return void
     */
    public function cleanCache()
    {
        $this->instances = null;
    }
}
