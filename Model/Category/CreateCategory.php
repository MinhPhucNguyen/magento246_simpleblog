<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Model\Category;

use Tigren\SimpleBlog\Model\Category;
use Tigren\SimpleBlog\Model\CategoryFactory;

class CreateCategory
{
    private $category;
    private $categoryFactory;

    public function __construct(
        Category        $category,
        CategoryFactory $categoryFactory
    )
    {
        $this->category = $category;
        $this->categoryFactory = $categoryFactory;
    }

    public function execute(array $postData)
    {
        $this->validateData($postData);

        $model = $this->categoryFactory->create();
        $model->setData($postData);
        $model->save();
        return $model->getData();
    }

    private function validateData(array $postData)
    {
        $errors = [];
        if (!isset($postData['name']) || empty($postData['name'])) {
            $errors[] = __('Category name is required');
        }
        if (!isset($postData['status']) || empty($postData['status'])) {
            $errors[] = __('Status is required');
        }
        return $errors;
    }
}
