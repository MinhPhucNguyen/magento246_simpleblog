<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Model;

use Magento\Framework\Exception\LocalizedException;
use Tigren\SimpleBlog\Api\BlogRepositoryInterface;
use Tigren\SimpleBlog\Api\Data\BlogInterface;

class BlogRepository implements BlogRepositoryInterface
{
    /**
     * @var BlogFactory
     */
    private BlogFactory $blogFactory;

    /**
     * @var ResourceModel\Blog
     */
    private ResourceModel\Blog $resource;

    /**
     * @var ResourceModel\Blog\CollectionFactory
     */
    private ResourceModel\Blog\CollectionFactory $collectionFactory;

    /**
     * @param BlogFactory $blogFactory
     * @param ResourceModel\Blog $resource
     * @param ResourceModel\Blog\CollectionFactory $collectionFactory
     */
    public function __construct(
        BlogFactory                          $blogFactory,
        ResourceModel\Blog                   $resource,
        ResourceModel\Blog\CollectionFactory $collectionFactory
    )
    {
        $this->blogFactory = $blogFactory;
        $this->resource = $resource;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param int $id
     * @return BlogInterface
     * @throws LocalizedException
     */
    public function get(int $id): BlogInterface
    {
        $blog = $this->blogFactory->create();
        $this->resource->load($blog, $id);

        if (!$blog->getId()) {
            throw new LocalizedException(__('Blog with id "%1" does not exist.', $id));
        }
        
        return $blog;
    }
}
