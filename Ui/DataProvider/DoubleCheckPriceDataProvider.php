<?php

namespace MagentoModules\DoubleCheckPrice\Ui\DataProvider;

use Magento\Framework\Api\Search\SearchResultInterface;
use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceInterface;
use MagentoModules\DoubleCheckPrice\Api\GetDoubleCheckPriceListInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Magento\Ui\DataProvider\SearchResultFactory;

/**
 * DataProvider component.
 */
class DoubleCheckPriceDataProvider extends DataProvider
{
    /**
     * @var GetDoubleCheckPriceListInterface
     */
    private GetDoubleCheckPriceListInterface $getListQuery;

    /**
     * @var SearchResultFactory
     */
    private SearchResultFactory $searchResultFactory;

    /**
     * @var array
     */
    private array $loadedData = [];

    /**
     * @param string                           $name
     * @param string                           $primaryFieldName
     * @param string                           $requestFieldName
     * @param ReportingInterface               $reporting
     * @param SearchCriteriaBuilder            $searchCriteriaBuilder
     * @param RequestInterface                 $request
     * @param FilterBuilder                    $filterBuilder
     * @param GetDoubleCheckPriceListInterface $getListQuery
     * @param SearchResultFactory              $searchResultFactory
     * @param array                            $meta
     * @param array                            $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        GetDoubleCheckPriceListInterface $getListQuery,
        SearchResultFactory $searchResultFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
        $this->getListQuery = $getListQuery;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * Returns searching result.
     *
     * @return SearchResultInterface
     */
    final public function getSearchResult(): SearchResultInterface
    {
        $searchCriteria = $this->getSearchCriteria();
        $result = $this->getListQuery->execute($searchCriteria);

        return $this->searchResultFactory->create(
            $result->getItems(),
            $result->getTotalCount(),
            $searchCriteria,
            DoubleCheckPriceInterface::DOUBLE_CHECK_PRICE_ID
        );
    }

    /**
     * Get data.
     *
     * @return array
     */
    final public function getData(): array
    {
        if ($this->loadedData) {
            return $this->loadedData;
        }
        $this->loadedData = parent::getData();
        $itemsById = [];

        foreach ($this->loadedData['items'] as $item) {
            $itemsById[(int)$item[DoubleCheckPriceInterface::DOUBLE_CHECK_PRICE_ID]] = $item;
        }

        if ($id = $this->request->getParam(DoubleCheckPriceInterface::DOUBLE_CHECK_PRICE_ID)) {
            $this->loadedData['entity'] = $itemsById[(int)$id];
        }

        return $this->loadedData;
    }
}
