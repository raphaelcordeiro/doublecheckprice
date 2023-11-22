<?php

namespace MagentoModules\DoubleCheckPrice\Controller\Adminhtml\DoubleCheckPrice;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use MagentoModules\DoubleCheckPrice\Api\DoubleCheckPriceRepositoryInterface;
use MagentoModules\DoubleCheckPrice\Helper\Data as HelperData;

/**
 * Mass Approval for DoubleCheckPrice controller action.
 */
class MassApproval extends Action implements HttpPostActionInterface
{
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
        HelperData                      $helperData
    ) {
        parent::__construct($context);
        $this->doubleCheckPriceRepository = $doubleCheckPriceRepository;
        $this->helperData = $helperData;
    }

    /**
     * Mass Approval Action.
     *
     * @return ResponseInterface|ResultInterface
     */
    final public function execute(): ResultInterface|ResponseInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $ids = $this->getRequest()->getParam('selected');

        if (!is_array($ids)) {
            $this->messageManager->addErrorMessage(__('No items selected.'));
            return $resultRedirect->setPath('*/*/');
        }

        try {
            foreach ($ids as $id) {
                $this->doubleCheckPriceRepository->approve($id);
                $this->helperData->dispatchEvent('price_change_approved', ['id' => $id]);
            }

            $this->messageManager->addSuccessMessage(__('A total of %1 item(s) were approved.', count($ids)));
        } catch (CouldNotSaveException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        return $resultRedirect->setPath('*/*/');
    }
}
