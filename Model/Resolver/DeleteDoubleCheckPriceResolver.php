<?php


namespace MagentoModules\DoubleCheckPrice\Model\Resolver;

use Exception;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use MagentoModules\DoubleCheckPrice\Api\DoubleCheckPriceRepositoryInterface;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Psr\Log\LoggerInterface;
use Magento\Framework\AuthorizationInterface;

class DeleteDoubleCheckPriceResolver implements ResolverInterface
{
    /**
     * @var DoubleCheckPriceRepositoryInterface
     */
    private DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;
    /**
     * @var AuthorizationInterface
     */
    private AuthorizationInterface $authorization;

    /**
     * @param DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository
     * @param AuthorizationInterface              $authorization
     */
    public function __construct(
        DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository,
        AuthorizationInterface $authorization
    ) {
        $this->doubleCheckPriceRepository = $doubleCheckPriceRepository;
        $this->authorization = $authorization;
    }

    /**
     * Resolve Delete Price change requests.
     *
     * @param  Field            $field
     * @param  ContextInterface $context
     * @param  ResolveInfo      $info
     * @param  array|null       $value
     * @param  array|null       $args
     * @return array
     * @throws GraphQlAuthorizationException
     * @throws GraphQlNoSuchEntityException
     */
    final public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ): array {
        if (!$this->authorization->isAllowed('MagentoModules_DoubleCheckPrice::delete')) {
            throw new GraphQlAuthorizationException(
                __('Current user does not have access to the resource "MagentoModules_DoubleCheckPrice::delete"')
            );
        }
        try{
            $this->doubleCheckPriceRepository->deleteById($args['id']);
            return ['success' => true, 'message' => 'Request deleted successfully'];
        }catch (Exception $exception){
            $this->logger->error($exception->getMessage());
            throw new GraphQlNoSuchEntityException(__($exception->getMessage()));
        }
    }
}
