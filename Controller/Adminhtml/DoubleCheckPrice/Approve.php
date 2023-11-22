<?php

namespace MagentoModules\DoubleCheckPrice\Controller\Adminhtml\DoubleCheckPrice;

use MagentoModules\DoubleCheckPrice\Api\DoubleCheckPriceRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use MagentoModules\DoubleCheckPrice\Helper\Data as HelperData;

/**
 * Save DoubleCheckPrice controller action.
 */
class Approve extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'MagentoModules_DoubleCheckPrice::approve';

    /**
     * @var DoubleCheckPriceRepositoryInterface
     */
    private DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository;
    /**
     * @var HelperData
     */
    private HelperData $helperData;

    /**
     * @param Context                             $context
     * @param DoubleCheckPriceRepositoryInterface $doubleCheckPriceRepository
     * @param HelperData                          $helperData
     */
    public function __construct(
        Context                          $context,
        DoubleCheckPriceRepositoryInterface    $doubleCheckPriceRepository,
        HelperData                       $helperData
    ) {
        parent::__construct($context);
        $this->doubleCheckPriceRepository = $doubleCheckPriceRepository;
        $this->helperData = $helperData;
    }

    /**
     * Save DoubleCheckPrice Action.
     *
     * @return ResponseInterface|ResultInterface
     */
    final public function execute(): ResultInterface|ResponseInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');

        try {
            $this->doubleCheckPriceRepository->approve($id);
            $this->helperData->dispatchEvent('price_change_approved', ['id' => $id]);
            $this->messageManager->addSuccessMessage(
                __('The price change request was saved successfully')
            );
        } catch (CouldNotSaveException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        return $resultRedirect->setPath('*/*/');
    }
}
