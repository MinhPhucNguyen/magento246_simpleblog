<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Block\View;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Tigren\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;

class BlogList extends Template
{

    protected $blogCollectionFactory;

    public function __construct(
        Context               $context,
        BlogCollectionFactory $blogCollectionFactory
    )
    {
        $this->blogCollectionFactory = $blogCollectionFactory;
        parent::__construct($context);
    }

    public function getBlogsByCategory($categoryId)
    {
        $blogList = $this->blogCollectionFactory->create();
        $blogList->addFieldToFilter('category_id', $categoryId)->addFieldToSelect('*')->getData();
        return $blogList;
    }
}

