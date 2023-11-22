<?php

namespace MagentoModules\DoubleCheckPrice\Api\Data;

use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceSearchResultsInterface;

interface DoubleCheckPricePendingApprovalsInterface
{
    /**
     * @return DoubleCheckPriceSearchResultsInterface
     */
    public function execute(): DoubleCheckPriceSearchResultsInterface;
}
