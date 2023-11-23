<?php

namespace MagentoModules\DoubleCheckPrice\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\StateException;
use MagentoModules\DoubleCheckPrice\Api\DoubleCheckPriceRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Catalog\Api\ProductRepositoryInterface;
use MagentoModules\DoubleCheckPrice\Helper\Data as HelperData;

/**
 * Observes the `price_change_approved` event.
 */
class PriceChangeApprovedObserver implements ObserverInterface
{

    /**
     * @var DoubleCheckPriceRepositoryInterface
     */
    private DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository;
    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;
    /**
     * @var HelperData
     */
    private HelperData $helperData;

    /**
     * @param DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository
     * @param ProductRepositoryInterface          $productRepository
     * @param HelperData                          $helperData
     */
    public function __construct(
        DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository,
        ProductRepositoryInterface $productRepository,
        HelperData $helperData
    ) {
        $this->doubleCheckPriceRepository = $doubleCheckPriceRepository;
        $this->productRepository = $productRepository;
        $this->helperData = $helperData;
    }

    /**
     * Observer for price_change_approved.
     *
     * @param Observer $observer
     *
     * @return void
     * @throws NoSuchEntityException
     * @throws CouldNotSaveException
     */
    final public function execute(Observer $observer): void
    {
        $priceChangeId = $observer->getData('id');

        try {
            $requestPriceChange = $this->doubleCheckPriceRepository->getById($priceChangeId);
            $product = $this->productRepository->get($requestPriceChange->getSku());
            $price = $this->helperData->formatPrice($requestPriceChange->getNewPrice());
            $product->setPrice($price);
            $this->productRepository->save($product);

        } catch (NoSuchEntityException $e) {
            $entityNotFound = $e->getMessage() === 'No such entity with id = ' . $priceChangeId;
            throw new NoSuchEntityException(
                __(
                    $entityNotFound ? 'Price Change Request with id "%1" does not exist.' : 'Product with sku "%1" does not exist.',
                    $entityNotFound
                )
            );
        } catch (CouldNotSaveException|InputException|StateException $e) {
            throw new CouldNotSaveException(__('Could not save product with sku "%1"'));
        }
    }

}
