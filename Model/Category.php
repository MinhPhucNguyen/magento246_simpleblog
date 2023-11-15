<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Model;

use Magento\Framework\Model\AbstractModel;
use Tigren\SimpleBlog\Api\Data\CategoryInterface;


class Category extends AbstractModel implements CategoryInterface
{
    protected $_idFieldName = 'category_id';

    protected function _construct()
    {
        return $this->_init('Tigren\SimpleBlog\Model\ResourceModel\Category');
    }

    /**
     * @return void
     */
    public function getCategoryId()
    {
        return $this->getData(self::CATEGORY_ID);
    }

    /**
     * @param $categoryId
     * @return void
     */
    public function setCategoryId($categoryId)
    {
        return $this->setData(self::CATEGORY_ID, $categoryId);
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @return void
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @param $name
     * @return void
     */
    public function setName($name)
    {
        return $this->setData(self::NAME);
    }


    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @return void
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @param $status
     * @return void
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }


    /**
     * @return void
     */
    public function getCreateAt()
    {
        return $this->getData(self::CREATE_AT);
    }

    /**
     * @param $createdAt
     * @return void
     */
    public function setCreateAt($createdAt)
    {
        return $this->setData(self::CREATE_AT, $createdAt);
    }

    /**
     * @return void
     */
    public function getUpdateAt()
    {
        return $this->getData(self::UPDATE_AT);
    }

    /**
     * @param $updatedAt
     * @return void
     */
    public function setUpdateAt($updatedAt)
    {
        return $this->setData(self::UPDATE_AT, $updatedAt);
    }


}


