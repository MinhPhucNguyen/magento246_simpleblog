<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */


namespace Tigren\SimpleBlog\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\View\Result\PageFactory;
use Magento\Setup\Exception;
use Tigren\SimpleBlog\Model\BlogFactory;


class Save extends Action
{
    protected $pageFactory = false;
    protected $blogFactory;
    protected $formKeyValidator;

    public function __construct(
        Context     $context,
        PageFactory $pageFactory,
        BlogFactory $blogFactory,
        Validator   $formKeyValidator)
    {
        $this->pageFactory = $pageFactory;
        $this->blogFactory = $blogFactory;
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

        $data = $this->getRequest()->getPostValue();
//        print_r($data);
//        exit();

        try {
            if ($data) {
                $model = $this->blogFactory->create();
                $model->setData($data);
                if (isset($data['post_image']) && !empty($data['post_image'][0]['file'])) {
                    $imageName = $data['post_image'][0]['file'];
                    $model->setData('post_image', $imageName);
                }
                $model->save();

                $this->messageManager->addSuccessMessage(__("Create new blog successfully."));
                return $resultPage->setPath('*/*/');
            }
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e, __(__('Something went wrong. Please try again')));

        }
        return $resultPage->setPath('*/*/');
    }
}

