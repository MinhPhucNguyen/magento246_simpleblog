<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Throwable;
use Tigren\SimpleBlog\Model\CategoryFactory;
use Tigren\SimpleBlog\Model\ResourceModel\Category as CategoryResource;

class Delete extends Action implements HttpPostActionInterface
{
    public function __construct(
        Context                  $context,
        private CategoryResource $resource,
        private CategoryFactory  $categoryFactory
    )
    {
        parent::__construct($context);
    }

    public function execute()
    {
        $categoryId = (int)$this->getRequest()->getParam('category_id');
        $resultPage = $this->resultRedirectFactory->create();

        if (!$categoryId) {
            $this->messageManager->addErrorMessage(__('This category no longer exists.'));
            return $resultPage->setPath('*/*/');
        }

        $model = $this->categoryFactory->create();

        try {
            $model->load($categoryId);
            $model->delete();
            $this->messageManager->addSuccessMessage(__('The category has been deleted'));
        } catch (Throwable $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        return $resultPage->setPath('*/*/');
    }
}

