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
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\View\Result\PageFactory;
use Magento\Setup\Exception;
use Magento\Framework\Filesystem;
use Tigren\SimpleBlog\Model\BlogFactory;
use Tigren\SimpleBlog\Helper\GetFileNameFromUrl;
use Magento\Framework\Filesystem\Driver\File;

class Save extends Action
{
    protected $pageFactory = false;
    protected $blogFactory;
    protected $formKeyValidator;

    protected $getFileNameFromUrl;

    protected $file;

    protected $fileSystem;

    public function __construct(
        Context            $context,
        PageFactory        $pageFactory,
        BlogFactory        $blogFactory,
        GetFileNameFromUrl $getFileNameFromUrl,
        File               $file,
        Filesystem         $fileSystem,
        Validator          $formKeyValidator)
    {
        $this->pageFactory = $pageFactory;
        $this->blogFactory = $blogFactory;
        $this->getFileNameFromUrl = $getFileNameFromUrl;
        $this->formKeyValidator = $formKeyValidator;
        $this->file = $file;
        $this->fileSystem = $fileSystem;
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

        $blogId = $this->getRequest()->getParam('blog_id');

        $mediaBlogPath = $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath() . 'simpleblog/blog/';

        try {
            if ($data) {
                if (isset($blogId)) {
                    $model = $this->blogFactory->create()->load($blogId);

                    $currentPostImage = $model->getData('post_image');
                    $currentImageList = $model->getData('image_list');

                    $fileNamePostImage = $this->getFileNameFromUrl->getFileName($data['post_image'][0]['url']);
                    $postImagePath = $mediaBlogPath . 'post_image/' . $fileNamePostImage;
                    if ($currentPostImage !== $fileNamePostImage) {
                        $this->file->deleteFile($mediaBlogPath . 'post_image/' . $currentPostImage);
                        $model->setData('post_image', $fileNamePostImage);
                    } else {
                        unset($data['post_image']);
                    }

                    $fileNameImageList = $this->getFileNameFromUrl->getFileName($data['image_list'][0]['url']);
                    $imageListPath = $mediaBlogPath . 'image_list/' . $fileNameImageList;
                    if ($currentImageList !== $fileNameImageList) {
                        $this->file->deleteFile($mediaBlogPath . 'image_list/' . $currentImageList);
                        $model->setData('image_list', $fileNameImageList);
                    } else {
                        unset($data['image_list']);
                    }

                    $model->setData($data)->save();

                    $this->messageManager->addSuccessMessage(__("Updated blog successfully."));

                } else {

                    $model = $this->blogFactory->create();
                    $model->setData($data);

                    if (isset($data['post_image']) && !empty($data['post_image'][0]['file'])) {
                        $imageName = $data['post_image'][0]['file'];
                        $model->setData('post_image', $imageName);
                    }

                    if (isset($data['image_list']) && !empty($data['image_list'][0]['file'])) {
                        $imageName = $data['image_list'][0]['file'];
                        $model->setData('image_list', $imageName);
                    }

                    $model->save();
                    $this->messageManager->addSuccessMessage(__("Create new blog successfully."));
                }
            }
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e, __(__('Something went wrong. Please try again')));

        }
        return $resultPage->setPath('*/*/');
    }
}

