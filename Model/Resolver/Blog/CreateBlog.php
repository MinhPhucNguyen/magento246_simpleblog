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
use Tigren\SimpleBlog\Model\Blog\CreateBlog as CreateBlogModel;

class CreateBlog implements ResolverInterface
{
    protected $createBlog;

    public function __construct(CreateBlogModel $createBlog)
    {
        $this->createBlog = $createBlog;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (empty($args['input']) || !is_array($args['input'])) {
            throw new GraphQlInputException(__('"input" value should be specified'));
        }

        $data = $args['input'];

        $blog = $this->createBlog->execute($data);

        $blogData = $blog;

        if (empty($blogData)) {
            return [];
        }

        return [
            'blog_id' => $blogData['blog_id'],
            'category_id' => $blogData['category_id'],
            'title' => $blogData['title'],
            'author' => $blogData['author'],
            'full_content' => $blogData['full_content'],
            'short_content' => $blogData['short_content'],
            'post_image' => $blogData['post_image'],
            'image_list' => $blogData['image_list'],
            'status' => $blogData['status'],
        ];
    }
}


