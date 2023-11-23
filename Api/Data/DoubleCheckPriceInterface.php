<?php

namespace MagentoModules\DoubleCheckPrice\Api\Data;

interface DoubleCheckPriceInterface
{
    /**
     * String constants for property names
     */
    public const DOUBLE_CHECK_PRICE_ID = "double_check_price_id";
    public const OLD_PRICE = "old_price";
    public const NEW_PRICE = "new_price";
    public const SKU = "product_sku";
    public const ATTRIBUTE = 'attribute';
    public const USERNAME = "username";
    public const STATUS = "status";
    public const CREATED_AT = "created_at";
    public const UPDATED_AT = "updated_at";

    /**
     * Getter for DoubleCheckPriceId.
     *
     * @return int|null
     */
    public function getDoubleCheckPriceId(): ?int;

    /**
     * Setter for DoubleCheckPriceId.
     *
     * @param int|null $doubleCheckPriceId
     *
     * @return DoubleCheckPriceInterface
     */
    public function setDoubleCheckPriceId(?int $doubleCheckPriceId): DoubleCheckPriceInterface;

    /**
     * Getter for OldPrice.
     *
     * @return float|null
     */
    public function getOldPrice(): ?float;

    /**
     * Setter for OldPrice.
     *
     * @param float|null $oldPrice
     *
     * @return DoubleCheckPriceInterface
     */
    public function setOldPrice(?float $oldPrice): DoubleCheckPriceInterface;

    /**
     * Getter for NewPrice.
     *
     * @return float|null
     */
    public function getNewPrice(): ?float;

    /**
     * Setter for NewPrice.
     *
     * @param float|null $newPrice
     *
     * @return DoubleCheckPriceInterface
     */
    public function setNewPrice(?float $newPrice): DoubleCheckPriceInterface;

    /**
     * Getter for Sku.
     *
     * @return string|null
     */
    public function getSku(): ?string;

    /**
     * Setter for Sku.
     *
     * @param string|null $sku
     *
     * @return DoubleCheckPriceInterface
     */
    public function setSku(?string $sku): DoubleCheckPriceInterface;

    /**
     * Getter for Attribute.
     *
     * @return string|null
     */
    public function getAttribute(): ?string;

    /**
     * Setter for Attribute.
     *
     * @param string|null $attribute
     *
     * @return DoubleCheckPriceInterface
     */
    public function setAttribute(?string $attribute): DoubleCheckPriceInterface;

    /**
     * Getter for Username.
     *
     * @return string|null
     */
    public function getUserName(): ?string;

    /**
     * Setter for Username.
     *
     * @param string|null $username
     *
     * @return DoubleCheckPriceInterface
     */
    public function setUserName(?string $username): DoubleCheckPriceInterface;

    /**
     * Getter for Status.
     *
     * @return int|null
     */
    public function getStatus(): ?int;

    /**
     * Setter for Status.
     *
     * @param int|null $status
     *
     * @return DoubleCheckPriceInterface
     */
    public function setStatus(?int $status): DoubleCheckPriceInterface;

    /**
     * Getter for CreatedAt.
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Setter for CreatedAt.
     *
     * @param string|null $createdAt
     *
     * @return DoubleCheckPriceInterface
     */
    public function setCreatedAt(?string $createdAt): DoubleCheckPriceInterface;

    /**
     * Getter for UpdatedAt.
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * Setter for UpdatedAt.
     *
     * @param string|null $updatedAt
     *
     * @return DoubleCheckPriceInterface
     */
    public function setUpdatedAt(?string $updatedAt): DoubleCheckPriceInterface;
}
