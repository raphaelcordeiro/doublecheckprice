<?php

namespace MagentoModules\DoubleCheckPrice\Model\Data;

use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceInterface;
use Magento\Framework\DataObject;

class DoubleCheckPriceData extends DataObject implements DoubleCheckPriceInterface
{
    /**
     * Getter for DoubleCheckPriceId.
     *
     * @return int|null
     */
    final public function getDoubleCheckPriceId(): ?int
    {
        return $this->getData(self::DOUBLE_CHECK_PRICE_ID) === null ? null
            : (int)$this->getData(self::DOUBLE_CHECK_PRICE_ID);
    }

    /**
     * Setter for DoubleCheckPriceId.
     *
     * @param int|null $doubleCheckPriceId
     *
     * @return DoubleCheckPriceInterface
     */
    final public function setDoubleCheckPriceId(?int $doubleCheckPriceId): DoubleCheckPriceInterface
    {
        return $this->setData(self::DOUBLE_CHECK_PRICE_ID, $doubleCheckPriceId);
    }

    /**
     * Getter for OldPrice.
     *
     * @return float|null
     */
    final public function getOldPrice(): ?float
    {
        return $this->getData(self::OLD_PRICE) === null ? null
            : (float)$this->getData(self::OLD_PRICE);
    }

    /**
     * Setter for OldPrice.
     *
     * @param float|null $oldPrice
     *
     * @return DoubleCheckPriceInterface
     */
    final public function setOldPrice(?float $oldPrice): DoubleCheckPriceInterface
    {
        return $this->setData(self::OLD_PRICE, $oldPrice);
    }

    /**
     * Getter for NewPrice.
     *
     * @return float|null
     */
    final public function getNewPrice(): ?float
    {
        return $this->getData(self::NEW_PRICE) === null ? null
            : (float)$this->getData(self::NEW_PRICE);
    }

    /**
     * Setter for NewPrice.
     *
     * @param float|null $newPrice
     *
     * @return DoubleCheckPriceInterface
     */
    final public function setNewPrice(?float $newPrice): DoubleCheckPriceInterface
    {
        return $this->setData(self::NEW_PRICE, $newPrice);
    }

    /**
     * Getter for Sku.
     *
     * @return string|null
     */
    final public function getSku(): ?string
    {
        return $this->getData(self::SKU);
    }

    /**
     * Setter for Sku.
     *
     * @param string|null $sku
     *
     * @return DoubleCheckPriceInterface
     */
    final public function setSku(?string $sku): DoubleCheckPriceInterface
    {
        return $this->setData(self::SKU, $sku);
    }

    /**
     * Getter for Attribute.
     *
     * @return string|null
     */
    final public function getAttribute(): ?string
    {
        return $this->getData(self::ATTRIBUTE);
    }

    /**
     * Setter for Attribute.
     *
     * @param string|null $attribute
     *
     * @return DoubleCheckPriceInterface
     */
    final public function setAttribute(?string $attribute): DoubleCheckPriceInterface
    {
        return $this->getData(self::ATTRIBUTE);
    }

    /**
     * Getter for UserId.
     *
     * @return int|null
     */
    final public function getUserId(): ?int
    {
        return $this->getData(self::USER_ID) === null ? null
            : (int)$this->getData(self::USER_ID);
    }

    /**
     * Setter for UserId.
     *
     * @param int|null $userId
     *
     * @return DoubleCheckPriceInterface
     */
    final public function setUserId(?int $userId): DoubleCheckPriceInterface
    {
        return $this->setData(self::USER_ID, $userId);
    }

    /**
     * Getter for Status.
     *
     * @return int|null
     */
    final public function getStatus(): ?int
    {
        return $this->getData(self::STATUS) === null ? null
            : (int)$this->getData(self::STATUS);
    }

    /**
     * Setter for Status.
     *
     * @param int|null $status
     *
     * @return DoubleCheckPriceInterface
     */
    final public function setStatus(?int $status): DoubleCheckPriceInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Getter for CreatedAt.
     *
     * @return string|null
     */
    final public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Setter for CreatedAt.
     *
     * @param string|null $createdAt
     *
     * @return DoubleCheckPriceInterface
     */
    final public function setCreatedAt(?string $createdAt): DoubleCheckPriceInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Getter for UpdatedAt.
     *
     * @return string|null
     */
    final public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Setter for UpdatedAt.
     *
     * @param string|null $updatedAt
     *
     * @return DoubleCheckPriceInterface
     */
    final public function setUpdatedAt(?string $updatedAt): DoubleCheckPriceInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
