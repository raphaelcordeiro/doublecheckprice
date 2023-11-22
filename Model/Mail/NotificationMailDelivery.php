<?php

namespace MagentoModules\DoubleCheckPrice\Model\Mail;

use Exception;
use MagentoModules\DoubleCheckPrice\Api\NotificationMailDeliveryInterface;
use MagentoModules\DoubleCheckPrice\Helper\Data as HelperData;

class NotificationMailDelivery implements NotificationMailDeliveryInterface
{
     CONST MAIL_SENDER_CONFIG = 'mail_settings/mail_settings/mail_sender';
     CONST MAIL_RECIPIENT_CONFIG = 'mail_settings/mail_settings/mail_recipient';
     CONST MAIL_TEMPLATE_CONFIG = 'mail_settings/mail_settings/mail_template';

    /**
     * @var HelperData
     */
    private HelperData $helperData;

    /**
     * @param HelperData $helperData
     */
    public function __construct(
        HelperData $helperData
    ) {
        $this->helperData = $helperData;
    }

    /**
     * @param  string    $userName
     * @param  string $sku
     * @param  string $priceOld
     * @param  string $priceNew
     * @param  string $requestDate
     * @return void
     * @throws Exception
     */
    public function notificationMail(string $userName, string $sku, string $priceOld, string $priceNew, string $requestDate): void
    {

        if(!$userName || !$sku || !$priceOld || !$priceNew || !$requestDate) {
            throw new Exception('Not all required parameters are provided');
        }

        $user = $this->helperData->getUserByUsername($userName);

        $templateVars = [
            'sku' => $sku,
            'oldPrice' => $priceOld,
            'newPrice' => $priceNew,
            'requestDate' => $requestDate,
            'userName' => $user->getName()
        ];
        $mailSender = $this->helperData->getConfigValue(self::MAIL_SENDER_CONFIG);
        $recipient = $this->helperData->getConfigValue(self::MAIL_RECIPIENT_CONFIG);
        $mailTemplate = $this->helperData->getConfigValue(self::MAIL_TEMPLATE_CONFIG);
        $this->helperData->sendMail($templateVars, $mailSender, $recipient, $mailTemplate);
    }
}
