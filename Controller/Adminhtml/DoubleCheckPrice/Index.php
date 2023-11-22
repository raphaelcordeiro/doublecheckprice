<?php

namespace MagentoModules\DoubleCheckPrice\Controller\Adminhtml\DoubleCheckPrice;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * DoubleCheckPrice backend index (list) controller.
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session.
     */
    public const ADMIN_RESOURCE = 'MagentoModules_DoubleCheckPrice::management';

    /**
     * Execute action based on request and return result.
     *
     * @return ResultInterface|ResponseInterface
     */
    final public function execute(): ResultInterface|ResponseInterface
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('MagentoModules_DoubleCheckPrice::management');
        $resultPage->addBreadcrumb(__('Double Check Product Prices'), __('Double Check Product Prices'));
        $resultPage->addBreadcrumb(__('Manage Product Prices'), __('Manage Product Prices'));
        $resultPage->getConfig()->getTitle()->prepend(__('Price Changes List'));

        return $resultPage;
    }
}
