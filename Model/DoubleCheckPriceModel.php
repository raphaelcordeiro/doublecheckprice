<?php

namespace MagentoModules\DoubleCheckPrice\Model;

use MagentoModules\DoubleCheckPrice\Model\ResourceModel\DoubleCheckPriceResource;
use Magento\Framework\Model\AbstractModel;

class DoubleCheckPriceModel extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'double_check_price_model';

    /**
     * Initialize magento model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(DoubleCheckPriceResource::class);
    }
}
