<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Model\Resolver\Blog;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Tigren\SimpleBlog\Model\ResourceModel\Blog\CollectionFactory;

class Blog implements ResolverInterface
{

    protected $blogCollectionFactory;


    public function __construct(
        CollectionFactory $blogCollectionFactory
    )
    {
        $this->blogCollectionFactory = $blogCollectionFactory;
    }

    /**
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        return $this->getBlogs();
    }

    private function getBlogs(): array
    {
        $collection = $this->blogCollectionFactory->create();
        $collection->addFieldToFilter('status', 1);
        $collection->setOrder('published_at', 'DESC');
        return $collection->getData();
    }
}
