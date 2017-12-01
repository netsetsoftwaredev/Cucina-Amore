<?php
/**
 *
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\GiftCards\Api;

/**
 * @api
 */
interface GiftCardsRepositoryInterface
{
    /**
     * Create GiftCard
     *
     * @param \MageWorx\GiftCards\Api\Data\GiftCardsInterface $giftCard
     * @param bool $saveOptions
     * @return \MageWorx\GiftCards\Api\Data\GiftCardsInterface
     */
    public function save(\MageWorx\GiftCards\Api\Data\GiftCardsInterface $giftCard, $saveOptions = false);

    /**
     * Get GiftCard by Card Code
     *
     * @param string $giftCardCode
     * @param bool $editMode
     * @param int|null $storeId
     * @param bool $forceReload
     * @return \MageWorx\GiftCards\Api\Data\GiftCardsInterface
     */
    public function getByCode($giftCardCode, $editMode = false, $storeId = null, $forceReload = false);

    /**
     * Get Gift Card by id
     *
     * @param int $giftCardId
     * @param bool $editMode
     * @param int|null $storeId
     * @param bool $forceReload
     * @return \MageWorx\GiftCards\Api\Data\GiftCardsInterface
     */
    public function get($giftCardId, $editMode = false, $storeId = null, $forceReload = false);

    /**
     * Delete Gift Card
     *
     * @param \MageWorx\GiftCards\Api\Data\GiftCardsInterface $giftCard
     * @return bool Will returned True if deleted
     */
    public function delete(\MageWorx\GiftCards\Api\Data\GiftCardsInterface $giftCard);

    /**
     * Delete Gift Card by Card Code
     *
     * @param string $gifCardCode
     * @return bool Will returned True if deleted
     */
    public function deleteByCode($giftCardCode);

    /**
     * Delete Gift Card by Card Id
     *
     * @param string $gifCardId
     * @return bool Will returned True if deleted
     */
    public function deleteById($giftCardId);
}
