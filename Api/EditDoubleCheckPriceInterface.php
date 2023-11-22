<?php

namespace MagentoModules\DoubleCheckPrice\Api;

use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceInterface;

interface EditDoubleCheckPriceInterface
{
    /**
     * @param  int    $entityId
     * @param  string $sku
     * @param  float  $price
     * @return DoubleCheckPriceInterface
     */
    public function execute(int $entityId, string $sku, float $price): DoubleCheckPriceInterface;
}
