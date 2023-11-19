<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Controller\Blog;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Tigren\SimpleBlog\Model\CategoryFactory;

class Index implements HttpGetActionInterface
{

    protected $resultPageFactory;
    protected $categoryFactory;

    public function __construct(PageFactory $resultPageFactory, CategoryFactory $categoryFactory)
    {
        $this->categoryFactory = $categoryFactory;
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Simple Blog'));
        return $resultPage;
    }
}

