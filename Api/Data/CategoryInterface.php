<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Api\Data;

interface CategoryInterface
{
    const CREATE_AT = 'create_at';
    const UPDATE_AT = 'update_at';
    const CATEGORY_ID = 'category_id';
    const ID = 'id';

    const NAME = 'name';
    const DESCRIPTION = 'description';
    const STATUS = 'status';

    public function getCategoryId();

    public function setCategoryId($categoryId);

    public function getId();

    public function setId($id);

    public function getName();

    public function setName($name);

    public function getDescription();

    public function setDescription($description);

    public function getStatus();

    public function setStatus($status);

    public function getCreateAt();

    public function setCreateAt($createAt);

    public function getUpdateAt();

    public function setUpdateAt($updateAt);
}
