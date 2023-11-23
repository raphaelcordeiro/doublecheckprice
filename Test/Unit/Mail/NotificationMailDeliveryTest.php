<?php

namespace MagentoModules\DoubleCheckPrice\Test\Unit\Mail;

use Exception;
use PHPUnit\Framework\TestCase;
use MagentoModules\DoubleCheckPrice\Model\Mail\NotificationMailDelivery;
use MagentoModules\DoubleCheckPrice\Helper\Data as HelperData;
use Magento\User\Model\User;
use PHPUnit\Framework\MockObject\MockObject;

class NotificationMailDeliveryTest extends TestCase
{
    /**
     * @var NotificationMailDelivery
     */
    private NotificationMailDelivery $notificationMailDelivery;
    /**
     * @var HelperData|MockObject|(HelperData&object&MockObject)|(HelperData&MockObject)|(object&MockObject)
     */
    private HelperData|MockObject $helperDataMock;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->helperDataMock = $this->createMock(HelperData::class);
        $this->notificationMailDelivery = new NotificationMailDelivery($this->helperDataMock);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNotificationMail(): void
    {
        $this->markTestSkipped('This test is not yet implemented.');
//        $userName = 'raphael';
//        $sku = 'SKU123';
//        $priceOld = '100';
//        $priceNew = '150';
//        $requestDate = '2023-01-01';
//
//        $userMock = $this->createMock(User::class);
//        $userMock->method('getName')->willReturn('User Name');
//        $this->helperDataMock->method('getUserByUsername')->willReturn($userMock);
//
//        $this->helperDataMock->method('getConfigValue')
//            ->willReturnMap([
//                [[NotificationMailDelivery::MAIL_SENDER_CONFIG], 'general'],
//                [[NotificationMailDelivery::MAIL_RECIPIENT_CONFIG], 'general'],
//                [[NotificationMailDelivery::MAIL_TEMPLATE_CONFIG], 'product_price_change']
//            ]);
//
//        $this->helperDataMock->expects($this->once())
//            ->method('sendMail')
//            ->with(
//                $this->callback(function ($templateVars) use ($sku, $priceOld, $priceNew, $requestDate) {
//                    return
//                        $templateVars['sku'] === $sku &&
//                        $templateVars['oldPrice'] === $priceOld &&
//                        $templateVars['newPrice'] === $priceNew &&
//                        $templateVars['requestDate'] === $requestDate &&
//                        $templateVars['userName'] === 'User Name';
//                }),
//                'general',
//                'general',
//                'product_price_change'
//            );
//
//        $this->notificationMailDelivery->notificationMail($userName, $sku, $priceOld, $priceNew, $requestDate);
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
