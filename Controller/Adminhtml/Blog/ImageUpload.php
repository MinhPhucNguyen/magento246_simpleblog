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
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Setup\Exception;

class ImageUpload extends Action implements HttpPostActionInterface
{
    private WriteInterface $mediaDirectory;

    public function __construct(
        Context                       $context,
        FileSystem                    $fileSystem,
        private UploaderFactory       $uploaderFactory,
        private StoreManagerInterface $storeManager
    )
    {
        parent::__construct($context);
        $this->mediaDirectory = $fileSystem->getDirectoryWrite(DirectoryList::MEDIA);
    }

    /**
     * @return ResponseInterface|ResultInterface
     * @throws \Exception
     */
    public function execute()
    {

        //  trả về dữ liệu dạng json
        $jsonResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        try {
            $fileUploader = $this->uploaderFactory->create(['fileId' => 'post_image']);
            $fileUploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
            $fileUploader->setAllowRenameFiles(true);
            $fileUploader->setAllowCreateFolders(true);
            $fileUploader->setFilesDispersion(false);

//          New folder when upload image if not exist
            $imagePath = 'simpleblog/blog/post_image/';

//          Rename Image
            $renameFileName = time() . '.' . $fileUploader->getFileExtension();

//          Save image to pub media
            $result = $fileUploader->save($this->mediaDirectory->getAbsolutePath($imagePath), $renameFileName);

//          Get media url: http://localhost/magento2/pub/media/
            $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

//          Get image name: /simpleblog/blog/post_image/1619098231.png
            $filename = ltrim(str_replace('\\', '/', $result['file']), '/');

//          Return image on uploader
            $result['url'] = $mediaUrl . $imagePath . $filename;

            return $jsonResult->setData($result);

        } catch (LocalizedException $exception) {
            return $jsonResult->setData([
                'error' => $exception->getMessage(),
                'errorcode' => $exception->getCode()
            ]);
        } catch (Exception $e) {
            return $jsonResult->setData([
                'error' => $e->getMessage(),
                'errorcode' => $e->getCode()
            ]);
        }
    }
}
