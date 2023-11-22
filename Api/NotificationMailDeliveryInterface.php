<?php

namespace MagentoModules\DoubleCheckPrice\Api;

interface NotificationMailDeliveryInterface
{
    /**
     * @param  int    $userId
     * @param  string $sku
     * @param  string $priceOld
     * @param  string $priceNew
     * @param  string $requestDate
     * @return void
     */
    public function notificationMail(int $userId, string $sku, string $priceOld, string $priceNew, string $requestDate) : void;
}
