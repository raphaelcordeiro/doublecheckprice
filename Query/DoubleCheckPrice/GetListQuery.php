<?php

namespace MagentoModules\DoubleCheckPrice\Query\DoubleCheckPrice;

use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceSearchResultsInterface;
use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceSearchResultsInterfaceFactory;
use MagentoModules\DoubleCheckPrice\Api\GetListQueryInterface;
use MagentoModules\DoubleCheckPrice\Mapper\DoubleCheckPriceDataMapper;
use MagentoModules\DoubleCheckPrice\Model\ResourceModel\DoubleCheckPriceModel\DoubleCheckPriceCollection;
use MagentoModules\DoubleCheckPrice\Model\ResourceModel\DoubleCheckPriceModel\DoubleCheckPriceCollectionFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

/**
 * Get DoubleCheckPrice list by search criteria query.
 */
class GetListQuery implements GetListQueryInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;

    /**
     * @var DoubleCheckPriceCollectionFactory
     */
    private DoubleCheckPriceCollectionFactory $entityCollectionFactory;

    /**
     * @var DoubleCheckPriceDataMapper
     */
    private DoubleCheckPriceDataMapper $entityDataMapper;

    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @var DoubleCheckPriceSearchResultsInterfaceFactory
     */
    private DoubleCheckPriceSearchResultsInterfaceFactory $searchResultFactory;

    /**
     * @param CollectionProcessorInterface                  $collectionProcessor
     * @param DoubleCheckPriceCollectionFactory             $entityCollectionFactory
     * @param DoubleCheckPriceDataMapper                    $entityDataMapper
     * @param SearchCriteriaBuilder                         $searchCriteriaBuilder
     * @param DoubleCheckPriceSearchResultsInterfaceFactory $searchResultFactory
     */
    public function __construct(
        CollectionProcessorInterface                  $collectionProcessor,
        DoubleCheckPriceCollectionFactory             $entityCollectionFactory,
        DoubleCheckPriceDataMapper                    $entityDataMapper,
        SearchCriteriaBuilder                         $searchCriteriaBuilder,
        DoubleCheckPriceSearchResultsInterfaceFactory $searchResultFactory
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->entityCollectionFactory = $entityCollectionFactory;
        $this->entityDataMapper = $entityDataMapper;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * @param  SearchCriteriaInterface|null $searchCriteria
     * @return DoubleCheckPriceSearchResultsInterface
     */
    final public function execute(?SearchCriteriaInterface $searchCriteria = null): DoubleCheckPriceSearchResultsInterface
    {
        /**
        * @var DoubleCheckPriceCollection $collection
        */
        $collection = $this->entityCollectionFactory->create();

        if ($searchCriteria === null) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        $entityDataObjects = $this->entityDataMapper->map($collection);

        /**
        * @var DoubleCheckPriceSearchResultsInterface $searchResult
        */
        $searchResult = $this->searchResultFactory->create();
        $searchResult->setItems($entityDataObjects);
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }
}
