<?php

namespace MagentoModules\DoubleCheckPrice\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class FullName extends Column
{
    final public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] = $item['firstname'] . ' ' . $item['lastname'];
            }
        }

        return $dataSource;
    }
}
