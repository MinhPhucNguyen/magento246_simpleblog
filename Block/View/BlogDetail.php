<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Block\View;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Tigren\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class BlogDetail extends Template
{

    protected $blogCollectionFactory;
    protected $storeManager;

    public function __construct(
        Context               $context,
        BlogCollectionFactory $blogCollectionFactory,
        StoreManagerInterface $storeManager
    )
    {
        $this->blogCollectionFactory = $blogCollectionFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    public function getBlogDetail()
    {
        $blogId = $this->getRequest()->getParam('blog_id');
        $blogList = $this->blogCollectionFactory->create();
        $blogList->addFieldToFilter('blog_id', $blogId)->addFieldToSelect('*');
        $blogDetail = $blogList->getFirstItem();

        if ($blogDetail->getId()) {
            return $blogDetail->getData();
        }
    }

    public function getImageSrc($folderName, $fileName)
    {
        return $this->storeManager->getStore()->getBaseUrl(
                DirectoryList::MEDIA
            ) . 'simpleblog/blog/' . $folderName . '/' . $fileName;
    }
}
