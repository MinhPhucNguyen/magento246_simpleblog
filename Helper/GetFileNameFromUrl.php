<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Helper;

use Magento\Framework\Filesystem\Io\File;

class GetFileNameFromUrl
{
    protected $fileSystem;

    public function __construct(
        File $fileSystem
    )
    {
        $this->fileSystem = $fileSystem;
    }

    public function getFileName($url)
    {
        $fileName = $this->fileSystem->getPathInfo($url)['basename'];
        return $fileName;
    }
}
