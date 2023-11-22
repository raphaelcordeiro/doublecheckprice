<?php


namespace MagentoModules\DoubleCheckPrice\Model\Resolver;

use Exception;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use MagentoModules\DoubleCheckPrice\Model\ResourceModel\DoubleCheckPriceModel\DoubleCheckPriceCollectionFactory;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Psr\Log\LoggerInterface;
use Magento\Framework\AuthorizationInterface;
use MagentoModules\DoubleCheckPrice\Helper\Data as DataHelper;

class ListDoubleCheckPricePendingApprovalsResolver implements ResolverInterface
{
    private DoubleCheckPriceCollectionFactory $doubleCheckPriceCollectionFactory;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;
    /**
     * @var AuthorizationInterface
     */
    private AuthorizationInterface $authorization;
    /**
     * @var DataHelper
     */
    private DataHelper $dataHelper;

    /**
     * @param DoubleCheckPriceCollectionFactory $doubleCheckPriceCollectionFactory
     * @param AuthorizationInterface            $authorization
     * @param LoggerInterface                   $logger
     * @param DataHelper                        $dataHelper
     */
    public function __construct(
        DoubleCheckPriceCollectionFactory $doubleCheckPriceCollectionFactory,
        AuthorizationInterface $authorization,
        LoggerInterface $logger,
        DataHelper $dataHelper
    ) {
        $this->doubleCheckPriceCollectionFactory = $doubleCheckPriceCollectionFactory;
        $this->authorization = $authorization;
        $this->logger = $logger;
        $this->dataHelper = $dataHelper;
    }


    /**
     * Resolve List Price change requests.
     *
     * @param  Field       $field
     * @param  $context
     * @param  ResolveInfo $info
     * @param  array|null  $value
     * @param  array|null  $args
     * @return array
     * @throws GraphQlAuthorizationException
     * @throws GraphQlNoSuchEntityException
     */
    final public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array       $value = null,
        array       $args = null
    ): array {
        if (!$this->authorization->isAllowed('MagentoModules_DoubleCheckPrice::management')) {
            throw new GraphQlAuthorizationException(
                __('Current user does not have access to the resource "MagentoModules_DoubleCheckPrice::management"')
            );
        }

        try {
            $collection = $this->doubleCheckPriceCollectionFactory->create();
            $collection->addFieldToFilter('status', ['eq' => 0]);

            $items = [];
            foreach ($collection as $item) {
                $user = $this->dataHelper->getUserById($item->getUserId());
                $userName = $user ? $user->getName() : 'N/A';

                $items[] = [
                    'double_check_price_id' => $item->getDoubleCheckPriceId(),
                    'attribute'             => $item->getAttribute(),
                    'old_price'             => $item->getOldPrice(),
                    'new_price'             => $item->getNewPrice(),
                    'sku'                   => $item->getSku(),
                    'requester_name'             => $userName,
                    'status'                => $item->getStatus(),
                    'created_at'            => $item->getCreatedAt(),
                    'updated_at'            => $item->getUpdatedAt(),
                ];
            }

            return $items;
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            throw new GraphQlNoSuchEntityException(__($e->getMessage()));
        }
    }
}
