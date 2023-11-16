<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Model;

use Magento\Framework\Model\AbstractModel;
use Tigren\SimpleBlog\Api\Data\BlogInterface;

class Blog extends AbstractModel implements BlogInterface
{
    protected $_idFieldName = 'blog_id';

    protected function _construct()
    {
        $this->_init('Tigren\SimpleBlog\Model\ResourceModel\Blog');
    }


    public function getBlogId()
    {
        return $this->getData(self::BLOG_ID);
    }

    public function setBlogId($blogId)
    {
        return $this->setData(self::BLOG_ID, $blogId);
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

    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    public function getShortContent()
    {
        return $this->getData(self::SHORT_CONTENT);
    }

    public function setShortContent($shortContent)
    {
        return $this->setData(self::SHORT_CONTENT, $shortContent);
    }

    public function getFullContent()
    {
        return $this->getData(self::FULL_CONTENT);
    }

    public function setFullContent($fullContent)
    {
        return $this->setData(self::FULL_CONTENT, $fullContent);
    }

    public function getPublishedAt()
    {
        return $this->getData(self::PUBLISHED_AT);
    }

    public function setPublishedAt($publishedAt)
    {
        return $this->setData(self::PUBLISHED_AT, $publishedAt);
    }

    public function getPostImage()
    {
        return $this->getData(self::POST_IMAGE);
    }

    public function setPostImage($postImage)
    {
        return $this->setData(self::POST_IMAGE, $postImage);
    }

    public function getImageList()
    {
        return $this->getData(self::IMAGE_LIST);
    }

    public function setImageList($imageList)
    {
        return $this->setData(self::IMAGE_LIST, $imageList);
    }

    public function getAuthor()
    {
        return $this->getData(self::AUTHOR);
    }

    public function setAuthor($author)
    {
        return $this->setData(self::AUTHOR, $author);
    }
}
