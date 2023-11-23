<?php

namespace MagentoModules\DoubleCheckPrice\Ui\Component\Listing\Column;

use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\AuthorizationInterface;

/**
 * Class to build edit and delete link for each item.
 */
class DoubleCheckPriceBlockActions extends Column
{
    /**
     * Entity name.
     */
    private const ENTITY_NAME = 'DoubleCheckPrice';

    /**
     * Url paths.
     */
    private const EDIT_URL_PATH = 'double_check_price/doublecheckprice/edit';
    private const APPROVE_URL_PATH = 'double_check_price/doublecheckprice/approve';
    private const DELETE_URL_PATH = 'double_check_price/doublecheckprice/delete';

    /**
     * @var UrlInterface
     */
    private UrlInterface $urlBuilder;

    /**
     * @var AuthorizationInterface
     */
    private AuthorizationInterface $authorization;

    /**
     * @param ContextInterface       $context
     * @param UiComponentFactory     $uiComponentFactory
     * @param UrlInterface           $urlBuilder
     * @param AuthorizationInterface $authorization
     * @param array                  $components
     * @param array                  $data
     */
    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface       $urlBuilder,
        AuthorizationInterface $authorization,
        array              $components = [],
        array              $data = []
    ) {
        parent::__construct(
            $context,
            $uiComponentFactory,
            $components,
            $data
        );
        $this->authorization = $authorization;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Prepare data source.
     *
     * @param array $dataSource
     *
     * @return array
     */
    final public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item[DoubleCheckPriceInterface::DOUBLE_CHECK_PRICE_ID])) {
                    $entityName = static::ENTITY_NAME;
                    $urlData = [DoubleCheckPriceInterface::DOUBLE_CHECK_PRICE_ID => $item[DoubleCheckPriceInterface::DOUBLE_CHECK_PRICE_ID]];

                    if ($this->authorization->isAllowed('MagentoModules_DoubleCheckPrice::approve')) {
                        $editUrl = $this->urlBuilder->getUrl(static::APPROVE_URL_PATH, $urlData);
                        $item[$this->getData('name')]['Approve'] = $this->getActionData($editUrl, (string)__('Approve'));
                    }

                    if ($this->authorization->isAllowed('MagentoModules_DoubleCheckPrice::edit')) {
                        $editUrl = $this->urlBuilder->getUrl(static::EDIT_URL_PATH, $urlData);
                        $item[$this->getData('name')]['edit'] = $this->getActionData($editUrl, (string)__('Edit'));
                    }

                    if ($this->authorization->isAllowed('MagentoModules_DoubleCheckPrice::delete')) {
                        $deleteUrl = $this->urlBuilder->getUrl(static::DELETE_URL_PATH, $urlData);
                        $item[$this->getData('name')]['delete'] = $this->getActionData(
                            $deleteUrl,
                            (string)__('Delete'),
                            (string)__('Delete %1', $entityName),
                            (string)__('Are you sure you want to delete a %1 record?', $entityName)
                        );
                    }
                }
            }
        }

        return $dataSource;
    }

    /**
     * Get action link data array.
     *
     * @param string      $url
     * @param string      $label
     * @param string|null $dialogTitle
     * @param string|null $dialogMessage
     *
     * @return array
     */
    private function getActionData(
        string  $url,
        string  $label,
        ?string $dialogTitle = null,
        ?string $dialogMessage = null
    ): array {
        $data = [
            'href' => $url,
            'label' => $label,
            'post' => true,
            '__disableTmpl' => true
        ];

        if ($dialogTitle && $dialogMessage) {
            $data['confirm'] = [
                'title' => $dialogTitle,
                'message' => $dialogMessage
            ];
        }

        return $data;
    }
}
