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
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Driver\File;
use Throwable;
use Tigren\SimpleBlog\Model\BlogFactory;
use Tigren\SimpleBlog\Model\ResourceModel\Blog as BlogResource;

class Delete extends Action implements HttpPostActionInterface
{

    protected $filesystem;
    protected $file;

    public function __construct(
        Context              $context,
        private BlogResource $resource,
        FileSystem           $fileSystem,
        File                 $file,
        private BlogFactory  $blogFactory
    )
    {
        $this->file = $file;
        $this->filesystem = $fileSystem;
        parent::__construct($context);
    }

    public function execute()
    {

        $blogId = $this->getRequest()->getParam('blog_id');
        $resultPage = $this->resultRedirectFactory->create();

        if (!$blogId) {
            $this->messageManager->addErrorMessage(__('This blog no longer exists.'));
            return $resultPage->setPath('*/*/');
        }

        $model = $this->blogFactory->create();

//        Get media path
        $mediaBlogPath = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath() . 'simpleblog/blog/';

        try {
            $model->load($blogId);

//            Delete Image in media folder
            $fileNamePostImage = $model->getData('post_image');
            $fileNameImageList = $model->getData('image_list');


            if ($fileNamePostImage === "" && $fileNameImageList === "") {
                $model->delete();
            } else {
                if ($fileNamePostImage !== "") {
                    $mediaPath = $mediaBlogPath . 'post_image/' . $fileNamePostImage;
                    $this->deleteFileImage($mediaPath);

                }
                if ($fileNameImageList !== "") {
                    $mediaPath = $mediaBlogPath . 'image_list/' . $fileNameImageList;
                    $this->deleteFileImage($mediaPath);
                }
                $model->delete();
            }

            $this->messageManager->addSuccessMessage(__('The blog has been deleted'));
        } catch (Throwable $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        return $resultPage->setPath('*/*/');
    }

    protected function deleteFileImage($mediaPath)
    {
        if ($this->file->isExists($mediaPath)) {
            $this->file->deleteFile($mediaPath);
        }
    }
}

