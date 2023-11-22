<?php

namespace MagentoModules\DoubleCheckPrice\Model\ResourceModel;

use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class DoubleCheckPriceResource extends AbstractDb
{
    /**
     * @var string
     */
    protected string $_eventPrefix = 'double_check_price_resource_model';

    /**
     * Initialize resource model.
     */
    final protected function _construct(): void
    {
        $this->_init('double_check_price', DoubleCheckPriceInterface::DOUBLE_CHECK_PRICE_ID);
        $this->_useIsObjectNew = true;
    }
}
