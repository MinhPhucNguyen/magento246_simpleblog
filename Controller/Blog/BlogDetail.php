<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */


namespace Tigren\SimpleBlog\Controller\Blog;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;
use Tigren\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory;

class BlogDetail extends Action
{

    protected $jsonResultFactory;
    protected $blogCollectionFactory;

    protected $resultPageFactory;


    public function __construct(
        Context           $context,
        JsonFactory       $jsonResultFactory,
        CollectionFactory $blogCollectionFactory,
        PageFactory       $resultPageFactory
    )
    {
        $this->jsonResultFactory = $jsonResultFactory;
        $this->blogCollectionFactory = $blogCollectionFactory;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $blogId = $this->getRequest()->getParam('blog_id');

        $blogList = $this->blogCollectionFactory->create();

        $blogList->addFieldToFilter('blog_id', $blogId)->addFieldToSelect('*');
        $blogDetail = $blogList->getFirstItem();

        if ($blogDetail->getId()) {
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->prepend($blogDetail->getTitle());
            return $resultPage;
        }
    }
}
