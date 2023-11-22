<?php

namespace MagentoModules\DoubleCheckPrice\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * DoubleCheckPrice entity search result.
 */
interface DoubleCheckPriceSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Set items.
     *
     * @param \MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceInterface[] $items
     *
     * @return DoubleCheckPriceSearchResultsInterface
     */
    public function setItems(array $items): DoubleCheckPriceSearchResultsInterface;

    /**
     * Get items.
     *
     * @return \MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceInterface[]
     */
    public function getItems(): array;
}
