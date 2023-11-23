<?php

namespace MagentoModules\DoubleCheckPrice\Test\Unit\Observer;

use Exception;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Event\Observer;
use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceInterface;
use MagentoModules\DoubleCheckPrice\Api\DoubleCheckPriceRepositoryInterface;
use MagentoModules\DoubleCheckPrice\Helper\Data as HelperData;
use MagentoModules\DoubleCheckPrice\Observer\PriceChangeApprovedObserver;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PriceChangeApprovedObserverTest extends TestCase
{
    /** @var DoubleCheckPriceRepositoryInterface|MockObject */
    private $doubleCheckPriceRepositoryMock;

    /** @var ProductRepositoryInterface|MockObject */
    private $productRepositoryMock;

    /** @var HelperData|MockObject */
    private $helperDataMock;

    /** @var PriceChangeApprovedObserver */
    private $observer;

    protected function setUp(): void
    {
        $this->doubleCheckPriceRepositoryMock = $this->createMock(DoubleCheckPriceRepositoryInterface::class);
        $this->productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $this->helperDataMock = $this->createMock(HelperData::class);

        $this->observer = new PriceChangeApprovedObserver(
            $this->doubleCheckPriceRepositoryMock,
            $this->productRepositoryMock,
            $this->helperDataMock
        );
    }

    public function testExecuteWithSuccess(): void
    {
        $priceChangeId = 123;
        $sku = 'test-sku';
        $newPrice = 99.99;
        $formattedPrice = 100.00;

        $priceChangeMock = $this->createMock(DoubleCheckPriceInterface::class);
        $priceChangeMock->method('getSku')->willReturn($sku);
        $priceChangeMock->method('getNewPrice')->willReturn($newPrice);

        $productMock = $this->createMock(ProductInterface::class);
        $productMock->expects($this->once())->method('setPrice')->with($this->equalTo($formattedPrice));

        $this->doubleCheckPriceRepositoryMock->method('getById')->with($priceChangeId)->willReturn($priceChangeMock);
        $this->productRepositoryMock->method('get')->with($sku)->willReturn($productMock);
        $this->productRepositoryMock->expects($this->once())->method('save')->with($productMock);

        $this->helperDataMock->method('formatPrice')->willReturn($formattedPrice);

        $observer = new Observer(['id' => $priceChangeId]);

        $this->observer->execute($observer);
    }

    public function testExecuteWithProductNotFound(): void
    {
        $this->expectException(Exception::class);

        $priceChangeId = 123;
        $this->doubleCheckPriceRepositoryMock->method('getById')->with($priceChangeId)->willThrowException(new Exception());

        $observer = new Observer(['id' => $priceChangeId]);
        $this->observer->execute($observer);
    }
}
