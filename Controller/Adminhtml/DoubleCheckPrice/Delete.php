<?php

namespace MagentoModules\DoubleCheckPrice\Controller\Adminhtml\DoubleCheckPrice;

use MagentoModules\DoubleCheckPrice\Api\Data\DoubleCheckPriceInterface;
use MagentoModules\DoubleCheckPrice\Api\DeleteDoubleCheckPriceByIdInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Delete DoubleCheckPrice controller.
 */
class Delete extends Action implements HttpPostActionInterface, HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session.
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'MagentoModules_DoubleCheckPrice::delete';

    /**
     * @var DeleteDoubleCheckPriceByIdInterface
     */
    private DeleteDoubleCheckPriceByIdInterface $deleteByIdCommand;

    /**
     * @param Context                             $context
     * @param DeleteDoubleCheckPriceByIdInterface $deleteByIdCommand
     */
    public function __construct(
        Context                             $context,
        DeleteDoubleCheckPriceByIdInterface $deleteByIdCommand
    ) {
        parent::__construct($context);
        $this->deleteByIdCommand = $deleteByIdCommand;
    }

    /**
     * Delete DoubleCheckPrice action.
     *
     * @return ResultInterface
     */
    final public function execute(): ResultInterface
    {
        /**
 * @var ResultInterface $resultRedirect 
*/
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/*/');
        $entityId = (int)$this->getRequest()->getParam(DoubleCheckPriceInterface::DOUBLE_CHECK_PRICE_ID);

        try {
            $this->deleteByIdCommand->execute($entityId);
            $this->messageManager->addSuccessMessage(__('You have successfully deleted the request to change the price.'));
        } catch (CouldNotDeleteException|NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        return $resultRedirect;
    }
}
