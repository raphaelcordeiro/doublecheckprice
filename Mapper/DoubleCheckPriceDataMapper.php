<?php

namespace MagentoModules\DoubleCheckPrice\Mapper;

use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceInterface;
use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceInterfaceFactory;
use MagentoModules\DoubleCheckPrice\Model\DoubleCheckPriceModel;
use Magento\Framework\DataObject;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Converts a collection of DoubleCheckPrice entities to an array of data transfer objects.
 */
class DoubleCheckPriceDataMapper
{
    /**
     * @var DoubleCheckPriceInterfaceFactory
     */
    private DoubleCheckPriceInterfaceFactory $entityDtoFactory;

    /**
     * @param DoubleCheckPriceInterfaceFactory $entityDtoFactory
     */
    public function __construct(
        DoubleCheckPriceInterfaceFactory $entityDtoFactory
    ) {
        $this->entityDtoFactory = $entityDtoFactory;
    }

    /**
     * Map magento models to DTO array.
     *
     * @param AbstractCollection $collection
     *
     * @return array|DoubleCheckPriceInterface[]
     */
    public function map(AbstractCollection $collection): array
    {
        $results = [];
        /**
 * @var DoubleCheckPriceModel $item 
*/
        foreach ($collection->getItems() as $item) {
            /**
 * @var DoubleCheckPriceInterface|DataObject $entityDto 
*/
            $entityDto = $this->entityDtoFactory->create();
            $entityDto->addData($item->getData());

            $results[] = $entityDto;
        }

        return $results;
    }
}
