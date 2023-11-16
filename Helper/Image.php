<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Helper;


use Magento\Framework\UrlInterface;
use Magento\Framework\Filesystem;

class Image
{

    protected $subDir = 'simpleblog/blog/post_image/';

    protected $urlBuilder;

    protected $fileSystem;


    public function __construct(
        UrlInterface $urlBuilder,
        Filesystem   $fileSystem
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->fileSystem = $fileSystem;
    }

    public function getBaseUrl()
    {
//        print_r($this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $this->subDir);
//        exit();
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $this->subDir;
    }
}
