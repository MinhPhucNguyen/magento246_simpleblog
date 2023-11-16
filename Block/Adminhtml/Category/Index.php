<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Block\Adminhtml\Category;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Tigren\SimpleBlog\Model\CategoryFactory;

class Index extends Template

{
    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @param Context $context
     * @param CategoryFactory $categoryFactory
     */
    public function __construct(Context $context, CategoryFactory $categoryFactory
    )
    {
        $this->categoryFactory = $categoryFactory;
        parent::__construct($context);
    }

    /**
     * @return AbstractDb|AbstractCollection|null
     */
    public function getAllCategories()
    {
        $categoryList = $this->categoryFactory->create();
        return $categoryList->getCollection();
    }
}

