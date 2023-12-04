<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Model\Blog;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\ReadInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Tigren\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory;
use Magento\Framework\Filesystem\Driver\File\Mime;

class DataProvider extends AbstractDataProvider
{

    private ReadInterface $mediaDirectory;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param Filesystem $fileSystem
     * @param CollectionFactory $blogCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param Mime $mime
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        FileSystem $fileSystem,
        CollectionFactory $blogCollectionFactory,
        private StoreManagerInterface $storeManager,
        private Mime $mime,
        array $meta = [],
        array $data = [])
    {
        $this->collection = $blogCollectionFactory->create();
        $this->mediaDirectory = $fileSystem->getDirectoryRead(DirectoryList::MEDIA);
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array|mixed
     * @throws FileSystemException
     * @throws NoSuchEntityException
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        $this->loadedData = [];

        $imagePath = 'simpleblog/blog/';
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        foreach ($items as $blog) {
            $blogData = $blog->getData();

            $fileNamePostImage = $blogData['post_image'];
            $fileNameImageList = $blogData['image_list'];

            //Check if image exists
            if ($fileNamePostImage) {
                $fullImagePostPath = $this->mediaDirectory->getAbsolutePath($imagePath) . 'post_image/' . $fileNamePostImage;
                $blogData['post_image'] = null;
                $blogData['post_image'] = [
                    array(
                        'name' => $fileNamePostImage,
                        'url' => $baseUrl . $imagePath . 'post_image/' . $fileNamePostImage,
                        'size' => $this->mediaDirectory->stat($fullImagePostPath)['size'],
                        'type' => $this->mime->getMimeType($fullImagePostPath) //getMimeType() get extensions like png, jpeg...
                    )
                ];
            }

            //Check if image exists
            if ($fileNameImageList) {
                $fullImageListPath = $this->mediaDirectory->getAbsolutePath($imagePath) . 'image_list/' . $fileNameImageList;
                $blogData['image_list'] = null;
                $blogData['image_list'] = [
                    array(
                        'name' => $fileNameImageList,
                        'url' => $baseUrl . $imagePath . 'image_list/' . $fileNameImageList,
                        'size' => $this->mediaDirectory->stat($fullImageListPath)['size'],
                        'type' => $this->mime->getMimeType($fullImageListPath) //getMimeType() get extensions like png, jpeg...
                    )
                ];
            }

            $this->loadedData[$blog->getId()] = $blogData;
        }
        return $this->loadedData;
    }
}
