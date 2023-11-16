<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */


namespace Tigren\SimpleBlog\Controller\Adminhtml\Category;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;
use Magento\Setup\Exception;
use Tigren\SimpleBlog\Model\CategoryFactory;
use Magento\Framework\Data\Form\FormKey\Validator;

class Save extends Action
{
    protected $pageFactory = false;
    protected $categoryFactory;
    protected $formKeyValidator;


    public function __construct(Context $context, PageFactory $pageFactory, CategoryFactory $categoryFactory, Validator $formKeyValidator)
    {
        $this->pageFactory = $pageFactory;
        $this->categoryFactory = $categoryFactory;
        $this->formKeyValidator = $formKeyValidator;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultRedirectFactory->create();
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            $this->messageManager->addErrorMessage(__('Form key is invalidate'));
            return $resultPage->setPath('*/*/');
        }

//        Get data input from category form
        $data = $this->getRequest()->getPostValue();
//        var_dump($data);

        try {
            if ($data) {
                $model = $this->categoryFactory->create();
                $model->setData($data)->save();
                $this->messageManager->addSuccessMessage(__("Create Category Successfully."));
                return $resultPage->setPath('simpleblog/category/index');
            }
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e, __('Something went wrong. Please try again'));
        }
        return $resultPage->setPath('simpleblog/category/index');
    }
}
