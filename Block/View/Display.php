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
use Tigren\SimpleBlog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;

class Display extends Template
{

    protected $categoryFactory;

    public function __construct(
        Context                   $context,
        CategoryCollectionFactory $categoryCollectionFactory
    )
    {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        parent::__construct($context);
    }

    public function getCategoryList()
    {
        $categoryList = $this->categoryCollectionFactory->create();
        $categoryList->addFieldToSelect('*')->getData();
        return $categoryList;
    }
}

