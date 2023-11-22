<?php

namespace MagentoModules\DoubleCheckPrice\Test\Unit\Plugin;

use Exception;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductRepository;
use MagentoModules\DoubleCheckPrice\Api\DoubleCheckPriceRepositoryInterface;
use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceInterface;
use MagentoModules\DoubleCheckPrice\Model\Data\DoubleCheckPriceDataFactory as DoubleCheckPriceModelFactory;
use MagentoModules\DoubleCheckPrice\Helper\Data as HelperData;
use MagentoModules\DoubleCheckPrice\Model\Mail\NotificationMailDelivery;
use MagentoModules\DoubleCheckPrice\Plugin\ProductSaveBefore;
use PHPUnit\Framework\TestCase;

class ProductSaveBeforeTest extends TestCase
{
    private HelperData $helperDataMock;
    private DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepositoryMock;
    private DoubleCheckPriceModelFactory $doubleCheckPriceModelFactoryMock;
    private NotificationMailDelivery $notificationMailDeliveryMock;
    private ProductSaveBefore $productSaveBefore;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->helperDataMock = $this->createMock(HelperData::class);
        $this->doubleCheckPriceRepositoryMock = $this->createMock(DoubleCheckPriceRepositoryInterface::class);
        $this->doubleCheckPriceModelFactoryMock = $this->createMock(DoubleCheckPriceModelFactory::class);
        $this->notificationMailDeliveryMock = $this->createMock(NotificationMailDelivery::class);

        $this->productSaveBefore = new ProductSaveBefore(
            $this->helperDataMock,
            $this->doubleCheckPriceRepositoryMock,
            $this->doubleCheckPriceModelFactoryMock,
            $this->notificationMailDeliveryMock
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testBeforeSaveWithPriceChange(): void
    {
        $productMock = $this->createMock(Product::class);
        $productMock->method('getOrigData')->with('price')->willReturn(100);
        $productMock->method('getPrice')->willReturn(150);

        $doubleCheckPriceMock = $this->createMock(DoubleCheckPriceInterface::class);
        $this->doubleCheckPriceModelFactoryMock->method('create')->willReturn($doubleCheckPriceMock);

        $this->doubleCheckPriceRepositoryMock->expects($this->once())
            ->method('save')
            ->with($doubleCheckPriceMock);

        $this->helperDataMock->method('isEmailNotificationEnabled')->willReturn(true);

        $notificationMailDeliveryMock = $this->createMock(NotificationMailDelivery::class);
        $notificationMailDeliveryMock->expects($this->once())
            ->method('notificationMail');

        $this->productSaveBefore->beforeSave($this->createMock(ProductRepository::class), $productMock);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testBeforeSaveNoPriceChangeButOtherAttributesChange(): void
    {
        $productMock = $this->createMock(Product::class);
        $productMock->method('getOrigData')->willReturnMap([
            ['price', 100],
            ['name', 'Original Name'],
            ['description', 'Original Description']
        ]);
        $productMock->method('getData')->willReturnMap([
            ['price', 100],
            ['name', 'New Name'],
            ['description', 'New Description']
        ]);

        $this->doubleCheckPriceRepositoryMock->expects($this->never())
            ->method('save');

        $this->notificationMailDeliveryMock->expects($this->never())
            ->method('notificationMail');

        $this->productSaveBefore->beforeSave($this->createMock(ProductRepository::class), $productMock);
    }
}
