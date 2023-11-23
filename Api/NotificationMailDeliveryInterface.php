<?php

namespace MagentoModules\DoubleCheckPrice\Api;

interface NotificationMailDeliveryInterface
{
    /**
     * @param  string    $userName
     * @param  string $sku
     * @param  string $priceOld
     * @param  string $priceNew
     * @param  string $requestDate
     * @return void
     */
    public function notificationMail(string $userName, string $sku, string $priceOld, string $priceNew, string $requestDate) : void;
}
