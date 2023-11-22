<?php

namespace MagentoModules\DoubleCheckPrice\Api;

use Magento\Framework\Exception\CouldNotDeleteException;

/**
 * Delete DoubleCheckPrice by id Command.
 *
 * @api
 */
interface DeleteDoubleCheckPriceByIdInterface
{
    /**
     * Delete DoubleCheckPrice.
     *
     * @param  int $entityId
     * @return void
     * @throws CouldNotDeleteException
     */
    public function execute(int $entityId): void;
}
