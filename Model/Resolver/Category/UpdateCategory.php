<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Model\Resolver\Category;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Tigren\SimpleBlog\Model\CategoryFactory;

class UpdateCategory implements ResolverInterface
{
    protected $categoryFactory;

    public function __construct(CategoryFactory $categoryFactory)
    {
        $this->categoryFactory = $categoryFactory;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (empty($args['input']) || !is_array($args['input'])) {
            throw new GraphQlInputException(__('"input" value should be specified'));
        }

        $data = $args['input'];

        $category = $this->categoryFactory->create();

        $categoryId = $args['category_id'];

        if (isset($categoryId)) {
            $category->load($categoryId);
            $category->addData($data);
            $category->save();
        }

        return [
            'category_id' => $category['category_id'],
            'name' => $category['name'],
            'description' => $category['description'],
            'status' => $category['status'],
        ];
    }
}


