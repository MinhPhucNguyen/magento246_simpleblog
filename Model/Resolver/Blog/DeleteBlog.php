<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Model\Resolver\Blog;

use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Throwable;
use Tigren\SimpleBlog\Model\BlogFactory;

class DeleteBlog implements ResolverInterface
{
    protected $blogFactory;

    public function __construct(
        BlogFactory $blogFactory
    )
    {
        $this->blogFactory = $blogFactory;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (!isset($args['blog_id'])) {
            throw new GraphQlInputException(__('Required parameter "blog_id" is missing'));
        }

        $blogId = $args['blog_id'];

        $blog = $this->blogFactory->create();

        try {
            $blog->load($blogId);
            $blog->delete();
            return [
                'message' => __('The blog has been deleted successfully.')
            ];
        } catch (Throwable $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        }
    }
}

