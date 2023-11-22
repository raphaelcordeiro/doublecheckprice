<?php

namespace MagentoModules\DoubleCheckPrice\Model;

use Exception;
use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceInterface;
use MagentoModules\DoubleCheckPrice\Api\EditDoubleCheckPriceInterface;
use MagentoModules\DoubleCheckPrice\Api\DoubleCheckPriceRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

class EditDoubleCheckPrice implements EditDoubleCheckPriceInterface
{
    /**
     * @var DoubleCheckPriceRepositoryInterface
     */
    private DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository
     * @param LoggerInterface                     $logger
     */
    public function __construct(
        DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository,
        LoggerInterface $logger
    ) {
        $this->doubleCheckPriceRepository = $doubleCheckPriceRepository;
        $this->logger = $logger;
    }

    /**
     * @param  int    $entityId
     * @param  string $sku
     * @param  float  $price
     * @return DoubleCheckPriceInterface
     * @throws NoSuchEntityException
     * @throws Exception
     */
    final public function execute(int $entityId, string $sku, float $price): DoubleCheckPriceInterface
    {
        try {
            $doubleCheckPriceItem = $this->doubleCheckPriceRepository->getById($entityId);

            $doubleCheckPriceItem->setSku($sku);
            $doubleCheckPriceItem->setNewPrice($price);

            $this->doubleCheckPriceRepository->save($doubleCheckPriceItem);

            return $doubleCheckPriceItem;
        } catch (NoSuchEntityException $e) {
            $this->logger->error("Failed to edit price change request: Entity ID {$entityId} does not exist.");
            throw new NoSuchEntityException(__('Item with id "%1" does not exist.', $entityId));
        } catch(Exception $e){
            $this->logger->error('Failed to edit price change request: ' . $e->getMessage());
            throw new Exception(__('Failed to edit price change request: ' . $e->getMessage()));
        }
    }
}
