<?php

namespace MagentoModules\DoubleCheckPrice\Api;

use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceSearchResultsInterface;

/**
 * Get DoubleCheckPrice list.
 *
 * @api
 */
interface GetDoubleCheckPriceListInterface
{
    /**
     * Get DoubleCheckPrice list.
     *
     * @return array
     */
    public function execute(): array;
}
