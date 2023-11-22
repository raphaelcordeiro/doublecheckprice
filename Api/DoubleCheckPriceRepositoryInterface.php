<?php

namespace MagentoModules\DoubleCheckPrice\Api;

use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceInterface;

interface DoubleCheckPriceRepositoryInterface
{
    /**
     * @param  DoubleCheckPriceInterface $doubleCheckPrice
     * @return DoubleCheckPriceInterface
     */
    public function save(DoubleCheckPriceInterface $doubleCheckPrice): DoubleCheckPriceInterface;

    /**
     * @param  int $entityId
     * @return DoubleCheckPriceInterface
     */
    public function getById(int $entityId): DoubleCheckPriceInterface;

    /**
     * @param  DoubleCheckPriceInterface $doubleCheckPrice
     * @return void
     */
    public function delete(DoubleCheckPriceInterface $doubleCheckPrice): void;

    /**
     * @param  int $entityId
     * @return void
     */
    public function deleteById(int $entityId): void;

    /**
     * @param  int $entityId
     * @return void
     */
    public function approve(int $entityId): void;

    /**
     * @param  int   $entityId
     * @param  float $price
     * @return DoubleCheckPriceInterface
     */
    public function editPrice(int $entityId, float $price): DoubleCheckPriceInterface;
}
