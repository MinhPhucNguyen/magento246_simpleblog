<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Model\Blog;


use Tigren\SimpleBlog\Model\ResourceModel\Blog;

class CreateBlog
{
    private \Tigren\SimpleBlog\Model\Blog $blog;
    private Blog $resource;

    public function __construct(
        \Tigren\SimpleBlog\Model\Blog $blog,
        Blog                          $resource
    )
    {
        $this->blog = $blog;
        $this->resource = $resource;
    }

    public function execute(int $blogId, array $postData)
    {
        $this->validateData($postData);

        $blog = $this->blog;

        if ($blogId) {
            $this->resource->load($blog, $blogId);
        }

        $blog->setData($postData);
        $this->resource->save($blog);

        if ($blog->getId()) {
            $this->resource->load($blog, $blog->getId());
        }
        return $blog;

        return [];
    }


    private function validateData(array $postData)
    {
        $errors = [];
        if (!isset($postData['category_id']) || empty($postData['category_id'])) {
            $errors[] = __('Category is required');
        }
        if (!isset($postData['title']) || empty($postData['title'])) {
            $errors[] = __('Title is required');
        }
        if (!isset($postData['author']) || empty($postData['author'])) {
            $errors[] = __('Author is required');
        }
        if (!isset($postData['full_content']) || empty($postData['full_content'])) {
            $errors[] = __('Full Content is required');
        }
        if (!isset($postData['short_content']) || empty($postData['short_content'])) {
            $errors[] = __('Short Content is required');
        }
        if (!isset($postData['status']) || empty($postData['status'])) {
            $errors[] = __('Status is required');
        }
        return $errors;
    }
}
