<?php

namespace MagentoModules\DoubleCheckPrice\Test\Unit\Helper;

use Magento\Framework\Mail\TransportInterface;
use Magento\Store\Api\Data\StoreInterface;
use MagentoModules\DoubleCheckPrice\Helper\Data as HelperData;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Psr\Log\LoggerInterface;
use Magento\User\Model\UserFactory;
use Magento\Framework\Locale\FormatInterface;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Backend\Model\Auth\Session as AdminSession;


class DataTest extends TestCase
{
    /**
     * @var StoreManagerInterface|MockObject
     */
    private $storeManagerMock;

    /**
     * @var TransportBuilder|MockObject
     */
    private $transportBuilderMock;

    /**
     * @var HelperData
     */
    private $helperData;

    protected function setUp(): void
    {
        $this->storeManagerMock = $this->createMock(StoreManagerInterface::class);
        $this->transportBuilderMock = $this->createMock(TransportBuilder::class);
        $scopeConfigMock = $this->createMock(ScopeConfigInterface::class);
        $loggerMock = $this->createMock(LoggerInterface::class);
        $userFactoryMock = $this->createMock(UserFactory::class);
        $eventManagerMock = $this->createMock(EventManager::class);
        $localeFormatMock = $this->createMock(FormatInterface::class);
        $adminSessionMock = $this->createMock(AdminSession::class);
        $contextMock = $this->createMock(Context::class);

        $this->helperData = new HelperData(
            $this->storeManagerMock,
            $this->transportBuilderMock,
            $scopeConfigMock,
            $loggerMock,
            $userFactoryMock,
            $eventManagerMock,
            $localeFormatMock,
            $adminSessionMock,
            $contextMock
        );
    }


    public function testSendMail(): void
    {
        $templateVars = ['sku' => '123', 'oldPrice' => 15.00, 'newPrice' => 25.00, 'requestDate' => date('Y-m-d'), 'userName' => 'Raphael'];
        $mailSender = 'general';
        $recipient = 'general';
        $mailTemplate = 'mail_settings_delivery_mail_settings_mail_template';

        $storeMock = $this->createMock(StoreInterface::class);
        $storeMock->method('getId')->willReturn(1);
        $this->storeManagerMock->method('getStore')->willReturn($storeMock);

        $transportMock = $this->createMock(TransportInterface::class);
        $transportMock->expects($this->once())->method('sendMessage');

        $this->transportBuilderMock->method('setTemplateIdentifier')->with($mailTemplate)->willReturnSelf();
        $this->transportBuilderMock->method('setTemplateOptions')->willReturnSelf();
        $this->transportBuilderMock->method('setTemplateVars')->with($templateVars)->willReturnSelf();
        $this->transportBuilderMock->method('setFromByScope')->with($mailSender)->willReturnSelf();
        $this->transportBuilderMock->method('addTo')->with($recipient)->willReturnSelf();
        $this->transportBuilderMock->method('getTransport')->willReturn($transportMock);

        $this->helperData->sendMail($templateVars, $mailSender, $recipient, $mailTemplate);
    }
}
