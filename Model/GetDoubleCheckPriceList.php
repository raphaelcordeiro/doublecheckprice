<?php

namespace MagentoModules\DoubleCheckPrice\Model;

use Exception;
use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceSearchResultsInterface;
use MagentoModules\DoubleCheckPrice\Api\GetDoubleCheckPriceListInterface;
use MagentoModules\DoubleCheckPrice\Model\ResourceModel\DoubleCheckPriceModel\DoubleCheckPriceCollectionFactory as CollectionFactory;
use MagentoModules\DoubleCheckPrice\Helper\Data as DataHelper;
use Magento\Framework\Exception\NoSuchEntityException;

class GetDoubleCheckPriceList implements GetDoubleCheckPriceListInterface
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;
    /**
     * @var DataHelper
     */
    private DataHelper $dataHelper;

    /**
     * @param CollectionFactory $collectionFactory
     * @param DataHelper        $dataHelper
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        DataHelper $dataHelper
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->dataHelper = $dataHelper;
    }

    /**
     * @return array
     * @throws Exception
     */
    final public function execute(): array
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('status', ['eq' => 0]);
        if(!$collection->getSize()) {
            throw new NoSuchEntityException(__('No price change requests found.'));
        }
        $items = [];
        foreach ($collection as $item) {
            $user = $this->dataHelper->getUserByUsername($item->getUserName());
            $userName = $user->getName();

            $items[] = [
                'double_check_price_id' => $item->getDoubleCheckPriceId(),
                'attribute'             => $item->getAttribute(),
                'old_price'             => $item->getOldPrice(),
                'new_price'             => $item->getNewPrice(),
                'sku'                   => $item->getSku(),
                'requester_name'             => $userName,
                'status'                => $item->getStatus(),
                'created_at'            => $item->getCreatedAt(),
                'updated_at'            => $item->getUpdatedAt(),
            ];
        }

        return $items;
    }
}
