<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Model\Category;

namespace Tigren\SimpleBlog\Model\Category;

use Tigren\SimpleBlog\Model\CategoryFactory;
use Magento\Framework\Data\OptionSourceInterface;

class Options implements OptionSourceInterface
{


    public function toOptionArray()
    {
        $options = [];

        $options = [
            ['label' => __('Select...'), 'value' => '1'],
            ['label' => __('Sport'), 'value' => '2'],
            ['label' => __('Option 3'), 'value' => '3'],
            ['label' => __('Option 4'), 'value' => '4'],
            ['label' => __('Option 5'), 'value' => '5'],
        ];


        return $options;

    }
}
