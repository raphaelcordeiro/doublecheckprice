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

        $this->markTestSkipped('This test is not yet implemented.');
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
