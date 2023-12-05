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
use Tigren\SimpleBlog\Model\Category\CreateCategory as CreateCategoryModel;

class CreateCategory implements ResolverInterface
{
    protected $createCategory;

    public function __construct(CreateCategoryModel $createCategory)
    {
        $this->createCategory = $createCategory;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (empty($args['input']) || !is_array($args['input'])) {
            throw new GraphQlInputException(__('"input" value should be specified'));
        }

        $data = $args['input'];

        $category = $this->createCategory->execute($data);

        $categoryData = $category;

        if (empty($categoryData)) {
            return [];
        }

        return [
            'category_id' => $categoryData['category_id'],
            'name' => $categoryData['name'],
            'description' => $categoryData['description'],
            'status' => $categoryData['status'],
        ];
    }
}


