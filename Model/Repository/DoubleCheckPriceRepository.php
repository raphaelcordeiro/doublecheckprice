<?php

namespace MagentoModules\DoubleCheckPrice\Model\Repository;

use Exception;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;
use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceInterface;
use MagentoModules\DoubleCheckPrice\Api\DoubleCheckPriceRepositoryInterface;
use MagentoModules\DoubleCheckPrice\Model\DoubleCheckPriceModelFactory;
use MagentoModules\DoubleCheckPrice\Model\ResourceModel\DoubleCheckPriceResource;

class DoubleCheckPriceRepository implements DoubleCheckPriceRepositoryInterface
{
    private DoubleCheckPriceModelFactory $doubleCheckPriceModelFactory;
    private DoubleCheckPriceResource $doubleCheckPriceResource;

    /**
     * @param DoubleCheckPriceModelFactory $doubleCheckPriceModelFactory
     * @param DoubleCheckPriceResource     $doubleCheckPriceResource
     */
    public function __construct(
        DoubleCheckPriceModelFactory $doubleCheckPriceModelFactory,
        DoubleCheckPriceResource $doubleCheckPriceResource
    ) {
        $this->doubleCheckPriceModelFactory = $doubleCheckPriceModelFactory;
        $this->doubleCheckPriceResource = $doubleCheckPriceResource;
    }

    /**
     * @param  DoubleCheckPriceInterface $doubleCheckPrice
     * @return DoubleCheckPriceInterface
     * @throws CouldNotSaveException
     */
    final public function save(DoubleCheckPriceInterface $doubleCheckPrice): DoubleCheckPriceInterface
    {
        try {
            $this->doubleCheckPriceResource->save($doubleCheckPrice);
        } catch (Exception $e) {
            throw new CouldNotSaveException(__('Unable to save Price Change Request'), $e);
        }
        return $doubleCheckPrice;
    }

    /**
     * @param int $entityId
     * @return DoubleCheckPriceInterface
     * @throws Exception
     */
    final public function getById(int $entityId): DoubleCheckPriceInterface
    {
        $doubleCheckPrice = $this->doubleCheckPriceModelFactory->create();
        try {
            $this->doubleCheckPriceResource->load($doubleCheckPrice, $entityId);
        } catch (Exception $e){
            throw new Exception(__('Unable to find Price Change Request with ID "%1"', $entityId));
        }

        return $doubleCheckPrice;
    }

    /**
     * @param  DoubleCheckPriceInterface $doubleCheckPrice
     * @return void
     * @throws CouldNotDeleteException
     */
    final public function delete(DoubleCheckPriceInterface $doubleCheckPrice): void
    {
        try {
            $this->doubleCheckPriceResource->delete($doubleCheckPrice);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__('Unable to delete Price Change Request'), $e);
        }
    }

    /**
     * @param  int $entityId
     * @return void
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    final public function deleteById(int $entityId): void
    {
        $doubleCheckPrice = $this->getById($entityId);
        $this->delete($doubleCheckPrice);
    }

    /**
     * @param  int $entityId
     * @return void
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    final public function approve(int $entityId): void
    {
        $doubleCheckPrice = $this->getById($entityId);
        $doubleCheckPrice->setStatus(1);

        try {
            $this->save($doubleCheckPrice);
        } catch (CouldNotSaveException $e) {
            throw new CouldNotSaveException(__('Unable to approve Price Change Request with ID "%1"', $entityId), $e);
        }
    }


    /**
     * @param  int   $entityId
     * @param  float $price
     * @return DoubleCheckPriceInterface
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    final public function editPrice(int $entityId, float $price): DoubleCheckPriceInterface
    {
        try {
            $changeRequest = $this->getById($entityId);
            $changeRequest->setNewPrice($price);
            $this->save($changeRequest);
            return $changeRequest;
        } catch (NoSuchEntityException $e) {
            throw new NoSuchEntityException(__('Unable to find Price Change Request with ID "%1"', $entityId), $e);
        } catch (CouldNotSaveException $e) {
            throw new CouldNotSaveException(__('Unable to edit Price Change Request with ID "%1"', $entityId), $e);
        }
    }
}
