<?php

namespace MagentoModules\DoubleCheckPrice\Plugin;

use Exception;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductRepository;
use MagentoModules\DoubleCheckPrice\Api\DoubleCheckPriceRepositoryInterface;
use MagentoModules\DoubleCheckPrice\Model\Data\DoubleCheckPriceDataFactory as DoubleCheckPriceModelFactory;
use MagentoModules\DoubleCheckPrice\Helper\Data as HelperData;
use MagentoModules\DoubleCheckPrice\Model\Mail\NotificationMailDelivery;

class ProductSaveBefore
{
    /**
     * @var HelperData
     */
    private HelperData $helperData;
    /**
     * @var DoubleCheckPriceRepositoryInterface
     */
    private DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository;
    /**
     * @var NotificationMailDelivery
     */
    private NotificationMailDelivery $notificationMailDelivery;
    /**
     * @var DoubleCheckPriceModelFactory
     */
    private DoubleCheckPriceModelFactory $doubleCheckPriceModelFactory;

    /**
     * @param HelperData                          $helperData
     * @param DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository
     * @param DoubleCheckPriceModelFactory        $doubleCheckPriceModelFactory
     * @param NotificationMailDelivery            $notificationMailDelivery
     */
    public function __construct(
        HelperData $helperData,
        DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository,
        DoubleCheckPriceModelFactory $doubleCheckPriceModelFactory,
        NotificationMailDelivery $notificationMailDelivery
    ) {
        $this->helperData = $helperData;
        $this->doubleCheckPriceRepository = $doubleCheckPriceRepository;
        $this->doubleCheckPriceModelFactory = $doubleCheckPriceModelFactory;
        $this->notificationMailDelivery = $notificationMailDelivery;
    }

    /**
     * @param  ProductRepository $subject
     * @param  Product           $product
     * @return void
     * @throws Exception
     */
    final public function beforeSave(ProductRepository $subject, Product $product): void
    {
        $originalPrice = $product->getOrigData('price');
        $currentPrice = $product->getPrice();
        $loggedUsername = $this->helperData->getLoggedUserName();
        $sku = $product->getSku();

        if ($originalPrice !== null && $originalPrice != $currentPrice) {
            $doubleCheckPrice = $this->doubleCheckPriceModelFactory->create()
                ->setNewPrice($currentPrice)
                ->setOldPrice($originalPrice)
                ->setSku($sku)
                ->setUserName($loggedUsername)
                ->setStatus(0);

            $this->doubleCheckPriceRepository->save($doubleCheckPrice);
            if ($this->helperData->isEmailNotificationEnabled()) {
                $this->notificationMailDelivery->notificationMail($loggedUsername, $sku, $originalPrice, $currentPrice, date('Y-m-d H:i:s'));
            }
            $product->setPrice($originalPrice);
        }
    }
}
