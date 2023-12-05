<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Model\Resolver\Blog;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Tigren\SimpleBlog\Model\BlogFactory;

class UpdateBlog implements ResolverInterface
{
    protected $blogFactory;

    public function __construct(BlogFactory $blogFactory)
    {
        $this->blogFactory = $blogFactory;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (empty($args['input']) || !is_array($args['input'])) {
            throw new GraphQlInputException(__('"input" value should be specified'));
        }

        $data = $args['input'];

        $blogId = $args['blog_id'];

        $blog = $this->blogFactory->create();
        if (isset($blogId)) {
            $blog->load($blogId);
            $blog->setCategoryId($data['category_id']);
            $blog->addData($data);
            $blog->save();
        }

        return [
            'blog_id' => $blog['blog_id'],
            'category_id' => $blog['category_id'],
            'title' => $blog['title'],
            'author' => $blog['author'],
            'full_content' => $blog['full_content'],
            'short_content' => $blog['short_content'],
            'post_image' => $blog['post_image'],
            'image_list' => $blog['image_list'],
            'status' => $blog['status'],
        ];
    }
}


