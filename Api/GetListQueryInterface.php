<?php

namespace MagentoModules\DoubleCheckPrice\Api;

use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceSearchResultsInterface;

/**
 * Get DoubleCheckPrice list by search criteria query.
 *
 * @api
 */
interface GetListQueryInterface
{
    /**
     * Get DoubleCheckPrice list by search criteria.
     *
     * @return DoubleCheckPriceSearchResultsInterface
     */
    public function execute(): DoubleCheckPriceSearchResultsInterface;
}
