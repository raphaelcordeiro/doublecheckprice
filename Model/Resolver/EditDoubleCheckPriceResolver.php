<?php


namespace MagentoModules\DoubleCheckPrice\Model\Resolver;

use Exception;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use MagentoModules\DoubleCheckPrice\Api\DoubleCheckPriceRepositoryInterface;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;

class EditDoubleCheckPriceResolver implements ResolverInterface
{
    /**
     * @var DoubleCheckPriceRepositoryInterface
     */
    private DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository;

    /**
     * @param DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository
     */
    public function __construct(
        DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository
    ) {
        $this->doubleCheckPriceRepository = $doubleCheckPriceRepository;
    }

    /**
     * @param  Field       $field
     * @param  $context
     * @param  ResolveInfo $info
     * @param  array|null  $value
     * @param  array|null  $args
     * @return array
     * @throws GraphQlInputException
     */
    final public function resolve(
        Field       $field,
        $context,
        ResolveInfo $info,
        array       $value = null,
        array       $args = null
    ): array {
        if (!isset($args['id']) || !isset($args['sku']) || !isset($args['newPrice'])) {
            throw new GraphQlInputException(__('Required parameters: id, sku, and newPrice'));
        }

        try {
            $doubleCheckPrice = $this->doubleCheckPriceRepository->getById($args['id']);
            $doubleCheckPrice->setSku($args['sku']);
            $doubleCheckPrice->setNewPrice($args['newPrice']);
            $this->doubleCheckPriceRepository->save($doubleCheckPrice);

            return ['success' => true, 'message' => 'Price Change Request updated successfully'];
        } catch (Exception $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        }
    }
}
