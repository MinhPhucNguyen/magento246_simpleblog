<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Ui\Component\Listing\Column;

use Magento\Framework\DataObject;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Tigren\SimpleBlog\Helper\Image;

class PostImageThumbnail extends Column
{
    const NAME = 'thumbnail';

    const ALT_FIELD = 'name';

    private $imageHelper;

    private $urlBuilder;


    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        Image              $imageHelper,
        UrlInterface       $urlBuilder,
        array              $components = [],
        array              $data = []
    )
    {
        $this->imageHelper = $imageHelper;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {

                // to get image url from database
                $filename = $item[$fieldName];
//                print_r($filename);
//                exit();
                $item[$fieldName . '_src'] = $this->imageHelper->getBaseUrl() . $filename;
                $item[$fieldName . '_alt'] = $this->getAlt($item) ?: $filename;
                $item[$fieldName . '_orig_src'] = $this->imageHelper->getBaseUrl() . $filename;
            }
        }
        return $dataSource;
    }

    public function getUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
    }

    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return isset($row[$altField]) ? $row[$altField] : null;
    }
}
