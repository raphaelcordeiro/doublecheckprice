<?php

namespace MagentoModules\DoubleCheckPrice\Model\ResourceModel\DoubleCheckPriceModel;

use MagentoModules\DoubleCheckPrice\Model\DoubleCheckPriceModel;
use MagentoModules\DoubleCheckPrice\Model\ResourceModel\DoubleCheckPriceResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class DoubleCheckPriceCollection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'double_check_price_collection';

    /**
     * Initialize collection model.
     */
    final protected function _construct(): void
    {
        $this->_init(DoubleCheckPriceModel::class, DoubleCheckPriceResource::class);
    }

    /**
     * @return $this|DoubleCheckPriceCollection
     */
    final protected function _initSelect(): DoubleCheckPriceCollection|static
    {
        parent::_initSelect();

        $this->getSelect()->join(
            ['admin_user' => $this->getTable('admin_user')],
            'main_table.user_id = admin_user.user_id',
            ['user_firstname' => 'firstname', 'user_lastname' => 'lastname']
        );

        return $this;
    }
}
