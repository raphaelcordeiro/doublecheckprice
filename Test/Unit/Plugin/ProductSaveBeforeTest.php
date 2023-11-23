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
use Magento\User\Model\User;

class ProductSaveBeforeTest extends TestCase
{
    private $helperDataMock;
    private $doubleCheckPriceRepositoryMock;
    private $doubleCheckPriceModelFactoryMock;
    private $notificationMailDeliveryMock;
    private $doubleCheckPriceMock;
    private $productSaveBefore;

    protected function setUp(): void
    {
        $this->helperDataMock = $this->createMock(HelperData::class);
        $this->doubleCheckPriceRepositoryMock = $this->createMock(DoubleCheckPriceRepositoryInterface::class);
        $this->doubleCheckPriceModelFactoryMock = $this->createMock(DoubleCheckPriceModelFactory::class);
        $this->notificationMailDeliveryMock = $this->createMock(NotificationMailDelivery::class);
        $this->doubleCheckPriceMock = $this->createMock(DoubleCheckPriceInterface::class);

        $this->doubleCheckPriceModelFactoryMock->method('create')->willReturn($this->doubleCheckPriceMock);

        $this->productSaveBefore = new ProductSaveBefore(
            $this->helperDataMock,
            $this->doubleCheckPriceRepositoryMock,
            $this->doubleCheckPriceModelFactoryMock,
            $this->notificationMailDeliveryMock
        );
    }

    public function testBeforeSaveWithPriceChange(): void
    {
        $this->markTestSkipped('This test is not yet implemented.');
    }

    public function testBeforeSaveNoPriceChangeButOtherAttributesChange(): void
    {
        $this->markTestSkipped('This test is not yet implemented.');
    }
}
