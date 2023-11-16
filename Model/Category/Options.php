<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Model\Category;

use Tigren\SimpleBlog\Model\CategoryFactory;
use Magento\Framework\Data\OptionSourceInterface;

class Options implements OptionSourceInterface
{

    protected $categoryFactory;

    public function __construct(CategoryFactory $categoryFactory)
    {
        $this->categoryFactory = $categoryFactory;
    }

    public function toOptionArray()
    {
        $options = [];
        $categories = $this->categoryFactory->create()->getCollection();
//        echo "<pre>";
//        print_r($categories->getData());
//        die();
        foreach ($categories as $category) {
            $options[] = [
                'label' => $category->getName(),
                'value' => $category->getCategoryId()
            ];
        }

        return $options;

    }
}
