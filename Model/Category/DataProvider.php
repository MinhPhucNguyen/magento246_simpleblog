<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */


namespace Tigren\SimpleBlog\Model\Category;

use Magento\Framework\App\RequestInterface;
use Tigren\SimpleBlog\Model\CategoryFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Tigren\SimpleBlog\Model\ResourceModel\Category as CategoryResource;
use Tigren\SimpleBlog\Model\ResourceModel\Category\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    private array $loadedData;

    /**
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $employeeCollectionFactory
     * @param CategoryResource $categoryResource
     * @param CategoryFactory $categoryFactory
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $employeeCollectionFactory,
        private CategoryResource $categoryResource,
        private CategoryFactory $categoryFactory,
        private RequestInterface $request,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    )
    {
        $this->collection = $employeeCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $category = $this->getCurrentCategory();
        $this->loadedData[$category->getId()] = $category->getData();
        return $this->loadedData;
    }

    /**
     * @return mixed
     */
    private function getCurrentCategory()
    {
        $categoryId = $this->getCategoryId();
        $category = $this->categoryFactory->create();

        if (!$category) {
            return $category;
        }

        $this->resource->load($category, $categoryId);

        return $category;
    }

    /**
     * @return mixed
     */
    private function getCategoryId()
    {
        return $this->request->getParam($this->getRequestFieldName());
    }
}
