<?php


namespace MagentoModules\DoubleCheckPrice\Model\Resolver;

use Exception;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use MagentoModules\DoubleCheckPrice\Api\DoubleCheckPriceRepositoryInterface;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Psr\Log\LoggerInterface;
use Magento\Framework\AuthorizationInterface;
use MagentoModules\DoubleCheckPrice\Helper\Data as HelperData;

class ApproveDoubleCheckPriceResolver implements ResolverInterface
{
    /**
     * @var DoubleCheckPriceRepositoryInterface
     */
    private DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository;
    /**
     * @var AuthorizationInterface
     */
    private AuthorizationInterface $authorization;
    /**
     * @var HelperData
     */
    private HelperData $helperData;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository
     * @param AuthorizationInterface              $authorization
     * @param HelperData                          $helperData
     * @param LoggerInterface                     $logger
     */
    public function __construct(
        DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository,
        AuthorizationInterface $authorization,
        HelperData $helperData,
        LoggerInterface $logger
    ) {
        $this->doubleCheckPriceRepository = $doubleCheckPriceRepository;
        $this->authorization = $authorization;
        $this->helperData = $helperData;
        $this->logger = $logger;
    }

    /**
     * Resolve multiple requests.
     *
     * @param  Field            $field
     * @param  ContextInterface $context
     * @param  ResolveInfo      $info
     * @param  array|null       $value
     * @param  array|null       $args
     * @return array
     * @throws GraphQlAuthorizationException
     */
    final public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ): array {
        if (!$this->authorization->isAllowed('MagentoModules_DoubleCheckPrice::approve')) {
            throw new GraphQlAuthorizationException(
                __('Current user does not have access to the resource "MagentoModules_DoubleCheckPrice::delete"')
            );
        }

        try{
            $this->doubleCheckPriceRepository->approve($args['id']);
            $this->helperData->dispatchEvent('price_change_approved', ['id' => $args['id']]);
            return ['success' => true, 'message' => 'Price change approved'];
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
