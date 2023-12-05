<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Model\Resolver\Category;

use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Throwable;
use Tigren\SimpleBlog\Model\CategoryFactory;

class DeleteCategory implements ResolverInterface
{
    protected $categoryFactory;

    public function __construct(
        CategoryFactory $categoryFactory
    )
    {
        $this->categoryFactory = $categoryFactory;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (!isset($args['category_id'])) {
            throw new GraphQlInputException(__('Required parameter "category_id" is missing'));
        }

        $categoryId = $args['category_id'];

        $category = $this->categoryFactory->create();

        try {
            $category->load($categoryId);
            $category->delete();
            return [
                'message' => __('The category has been deleted successfully.')
            ];
        } catch (Throwable $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        }
    }
}

