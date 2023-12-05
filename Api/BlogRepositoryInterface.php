<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Api;

use Tigren\SimpleBlog\Api\Data\BlogInterface;

interface BlogRepositoryInterface
{
    /**
     * @param int $id
     * @return BlogInterface
     */
    public function get(int $id): BlogInterface;
}

