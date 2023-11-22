<?php

namespace MagentoModules\DoubleCheckPrice\Block\Form\DoubleCheckPrice;

use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Delete entity button.
 */
class Delete extends GenericButton implements ButtonProviderInterface
{
    /**
     * Retrieve Delete button settings.
     *
     * @return array
     */
    final public function getButtonData(): array
    {
        if (!$this->getDoubleCheckPriceId()) {
            return [];
        }

        return $this->wrapButtonSettings(
            __('Delete')->getText(),
            'delete',
            sprintf(
                "deleteConfirm('%s', '%s')",
                __('Are you sure you want to delete this price change request?'),
                $this->getUrl(
                    '*/*/delete',
                    [DoubleCheckPriceInterface::DOUBLE_CHECK_PRICE_ID => $this->getDoubleCheckPriceId()]
                )
            ),
            [],
            20
        );
    }
}
