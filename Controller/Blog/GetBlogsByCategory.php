<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */


namespace Tigren\SimpleBlog\Controller\Blog;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Tigren\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory;
use Magento\Framework\App\Action\Context;

class GetBlogsByCategory extends Action
{
    protected $jsonResultFactory;
    protected $blogCollectionFactory;

    public function __construct(
        Context           $context,
        JsonFactory       $jsonResultFactory,
        CollectionFactory $blogCollectionFactory
    )
    {
        $this->jsonResultFactory = $jsonResultFactory;
        $this->blogCollectionFactory = $blogCollectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $categoryId = $this->getRequest()->getParam('category_id');

        $blogList = $this->blogCollectionFactory->create();

        $blogList->addFieldToFilter('category_id', $categoryId);
        $blogs = $blogList->getData();

        $result = $this->jsonResultFactory->create();
        return $result->setData($blogs);
    }
}
