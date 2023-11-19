<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Block\Adminhtml\Blog;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Tigren\SimpleBlog\Model\BlogFactory;

class Index extends Template
{
    protected $blogFactory;

    public function __construct(Context $context, BlogFactory $blogFactory
    )
    {
        $this->$blogFactory = $blogFactory;
        parent::__construct($context);
    }
    
    public function getAllBlogs()
    {
        $blogList = $this->blogFactory->create();
        return $blogList->getCollection();
    }
}



