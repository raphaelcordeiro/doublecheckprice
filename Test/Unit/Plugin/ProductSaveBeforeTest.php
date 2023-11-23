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
//        // Configuração do Mock de Produto
//        $productMock = $this->createMock(Product::class);
//        $productMock->method('getOrigData')->with('price')->willReturn(100);
//        $productMock->method('getPrice')->willReturn(150);
//
//        // Configuração do Mock de DoubleCheckPriceInterface
//        $this->doubleCheckPriceMock->method('setNewPrice')->with($this->equalTo(150));
//
//        // Assegurando que o mesmo objeto mockado seja retornado
//        $this->doubleCheckPriceModelFactoryMock->method('create')->willReturn($this->doubleCheckPriceMock);
//
//        // Configuração das expectativas do método save
//        $this->doubleCheckPriceRepositoryMock->expects($this->once())
//            ->method('save')
//            ->with($this->identicalTo($this->doubleCheckPriceMock));  // Uso de identicalTo
//
//        // Configuração adicional dos mocks
//        $this->helperDataMock->method('isEmailNotificationEnabled')->willReturn(true);
//        $userMock = $this->createMock(User::class);
//        $userMock->method('getName')->willReturn('Test User');
//        $this->helperDataMock->method('getUserByUsername')->willReturn($userMock);
//
//        $notificationMailDeliveryMock = $this->createMock(NotificationMailDelivery::class);
//        $notificationMailDeliveryMock->expects($this->once())
//            ->method('notificationMail');
//
//        $this->productSaveBefore->beforeSave($this->createMock(ProductRepository::class), $productMock);
    }

    public function testBeforeSaveNoPriceChangeButOtherAttributesChange(): void
    {
        $this->markTestSkipped('This test is not yet implemented.');
//        $productMock = $this->createMock(Product::class);
//        $productMock->method('getOrigData')->willReturnMap([
//            ['price', 100],
//            ['name', 'Original Name'],
//            ['description', 'Original Description']
//        ]);
//        $productMock->method('getData')->willReturnMap([
//            ['price', 100],
//            ['name', 'New Name'],
//            ['description', 'New Description']
//        ]);
//
//        $this->doubleCheckPriceMock->expects($this->once())
//            ->method('setNewPrice')
//            ->with($this->equalTo(100));
//
//        $this->doubleCheckPriceRepositoryMock->expects($this->never())
//            ->method('save');
//
//        $this->notificationMailDeliveryMock->expects($this->never())
//            ->method('notificationMail');
//
//        $this->productSaveBefore->beforeSave($this->createMock(ProductRepository::class), $productMock);
    }
}
