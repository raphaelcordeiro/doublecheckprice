<?php

namespace MagentoModules\DoubleCheckPrice\Test\Unit\Mail;

use Exception;
use PHPUnit\Framework\TestCase;
use MagentoModules\DoubleCheckPrice\Model\Mail\NotificationMailDelivery;
use MagentoModules\DoubleCheckPrice\Helper\Data as HelperData;
use Magento\User\Model\User;

class NotificationMailDeliveryTest extends TestCase
{
    /**
     * @var NotificationMailDelivery
     */
    private $notificationMailDelivery;

    protected function setUp(): void
    {
        $this->helperDataMock = $this->createMock(HelperData::class);
        $this->notificationMailDelivery = new NotificationMailDelivery($this->helperDataMock);
    }

    public function testNotificationMail(): void
    {

        $userName = 'TestUser';
        $sku = 'SKU123';
        $priceOld = '100.00';
        $priceNew = '150.00';
        $requestDate = '2023-01-01';

        $userMock = $this->createMock(User::class);
        $userMock->method('getName')->willReturn($userName);
        $this->helperDataMock->method('getUserByUsername')->willReturn($userMock);

        $this->helperDataMock->expects($this->once())
            ->method('sendMail')
            ->with(
                $this->equalTo([
                    'sku' => $sku,
                    'oldPrice' => $priceOld,
                    'newPrice' => $priceNew,
                    'requestDate' => $requestDate,
                    'userName' => $userName
                ]),
                $this->anything(),
                $this->anything(),
                $this->anything()
            );

        $this->notificationMailDelivery->notificationMail($userName, $sku, $priceOld, $priceNew, $requestDate);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNotificationMailWithMissingParameters(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Not all required parameters are provided');

        $this->notificationMailDelivery->notificationMail(0, '', '', '', '');
    }
}
