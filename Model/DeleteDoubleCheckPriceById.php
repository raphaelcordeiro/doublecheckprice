<?php

namespace MagentoModules\DoubleCheckPrice\Model;

use Exception;
use MagentoModules\DoubleCheckPrice\Api\DeleteDoubleCheckPriceByIdInterface;
use MagentoModules\DoubleCheckPrice\Api\DoubleCheckPriceRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

class DeleteDoubleCheckPriceById implements DeleteDoubleCheckPriceByIdInterface
{
    /**
     * @var DoubleCheckPriceRepositoryInterface
     */
    private DoubleCheckPriceRepositoryInterface $repository;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param DoubleCheckPriceRepositoryInterface $repository
     * @param LoggerInterface                     $logger
     */
    public function __construct(
        DoubleCheckPriceRepositoryInterface $repository,
        LoggerInterface $logger
    ) {
        $this->repository = $repository;
        $this->logger = $logger;
    }

    /**
     * @param  int $entityId
     * @return void
     * @throws LocalizedException
     */
    final public function execute(int $entityId): void
    {
        try {
            $this->repository->deleteById($entityId);
        } catch (NoSuchEntityException $e) {
            $this->logger->error("Failed to delete price change request: Entity ID {$entityId} does not exist.");
            throw new LocalizedException(__('Price change request with id "%1" does not exist.', $entityId));
        } catch (Exception $e) {
            $this->logger->error("Error occurred while deleting price change request: {$e->getMessage()}");
            throw new LocalizedException(__('We can\'t delete the price change request right now. Please try again later.'));
        }
    }
}
