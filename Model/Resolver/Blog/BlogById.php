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
use Tigren\SimpleBlog\Api\BlogRepositoryInterface;

class BlogById implements ResolverInterface
{
    /**
     * @var BlogRepositoryInterface
     */
    private BlogRepositoryInterface $blogRepository;

    /**
     * @param BlogRepositoryInterface $blogRepository
     */
    public function __construct(BlogRepositoryInterface $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws GraphQlInputException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (!isset($args['id'])) {
            throw new GraphQlInputException(__('Blog id should be specified'));
        }

        $blogId = $args['id'];
        $blog = $this->blogRepository->get($blogId);

        if (!$blog->getId()) {
            return [];
        }

        $item = $blog->toArray();

        return [
            'blog_id' => $item['blog_id'],
            'category_id' => $item['category_id'],
            'title' => $item['title'],
            'author' => $item['author'],
            'full_content' => $item['full_content'],
            'short_content' => $item['short_content'],
            'post_image' => $item['post_image'],
            'image_list' => $item['image_list'],
            'status' => $item['status'],
        ];
    }
}


