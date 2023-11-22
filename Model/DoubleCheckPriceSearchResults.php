<?php

namespace MagentoModules\DoubleCheckPrice\Model;

use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * DoubleCheckPrice entity search results implementation.
 */
class DoubleCheckPriceSearchResults extends SearchResults implements DoubleCheckPriceSearchResultsInterface
{
    /**
     * Set items list.
     *
     * @param array $items
     *
     * @return DoubleCheckPriceSearchResultsInterface
     */
    public function setItems(array $items): DoubleCheckPriceSearchResultsInterface
    {
        return parent::setItems($items);
    }

    /**
     * Get items list.
     *
     * @return array
     */
    public function getItems(): array
    {
        return parent::getItems();
    }
}
