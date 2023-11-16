<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Api\Data;

interface BlogInterface
{
    const BLOG_ID = 'blog_id';
    const ID = 'id';
    const TITLE = 'title';
    const SHORT_CONTENT = 'short_content';
    const FULL_CONTENT = 'full_content';
    const PUBLISHED_AT = 'published_at';
    const POST_IMAGE = 'post_image';
    const IMAGE_LIST = 'image_list';
    const AUTHOR = 'author';

    public function getBlogId();

    public function setBlogId($blogId);

    public function getId();

    public function setId($id);

    public function getTitle();

    public function setTitle($title);

    public function getShortContent();

    public function setShortContent($shortContent);

    public function getFullContent();

    public function setFullContent($fullContent);

    public function getPublishedAt();

    public function setPublishedAt($publishedAt);

    public function getPostImage();

    public function setPostImage($postImage);

    public function getImageList();

    public function setImageList($imageList);

    public function getAuthor();

    public function setAuthor($author);

}
