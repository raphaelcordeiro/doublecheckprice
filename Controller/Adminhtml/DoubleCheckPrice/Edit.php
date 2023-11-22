<?php

namespace MagentoModules\DoubleCheckPrice\Controller\Adminhtml\DoubleCheckPrice;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Edit DoubleCheckPrice entity backend controller.
 */
class Edit extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session.
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'MagentoModules_DoubleCheckPrice::edit';

    /**
     * Edit DoubleCheckPrice action.
     *
     * @return Page|ResultInterface
     */
    final public function execute(): ResultInterface|Page
    {
        /**
 * @var Page $resultPage 
*/
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('MagentoModules_DoubleCheckPrice::management');
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Product Prices'));

        return $resultPage;
    }
}
