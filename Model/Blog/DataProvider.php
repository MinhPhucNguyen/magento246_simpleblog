<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Model\Blog;


use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Tigren\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory;
use Tigren\SimpleBlog\Model\PostFactory;

class DataProvider extends AbstractDataProvider
{

    protected $fileSystem;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $blogCollectionFactory,
        Filesystem $fileSystem,
        private StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = [])
    {
        $this->filesystem = $fileSystem;
        $this->collection = $blogCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        $this->loadedData = [];

        $mediaBlogPath = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'simpleblog/blog/';

        foreach ($items as $blog) {
            $blogData = $blog->getData();
//            print_r($blogData);
//            exit();
            $fileNamePostImage = $blogData['post_image'];
            $fileNameImageList = $blogData['image_list'];

            unset($blogData['post_image']);
            unset($blogData['image_list']);

            $blogData['post_image'] = [
                array(
                    'name' => $fileNamePostImage,
                    'url' => $mediaBlogPath . 'post_image/' . $fileNamePostImage
                )
            ];

            $blogData['image_list'] = [
                array(
                    'name' => $fileNameImageList,
                    'url' => $mediaBlogPath . 'image_list/' . $fileNameImageList
                )
            ];


            $this->loadedData[$blog->getId()] = $blogData;
        }
        return $this->loadedData;
    }

}
