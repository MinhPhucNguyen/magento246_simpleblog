<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\SimpleBlog\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Tigren\HelloWorld\Helper\Data;

class Config extends Action
{
    protected $helperData;

    public function __construct(Context $context, Data $helperData)
    {
        $this->helperData = $helperData;
        return parent::__construct($context);
    }

    public function execute()
    {
        print_r($this->helperData->getGeneralConfig('enable'));
        print_r($this->helperData->getGeneralConfig('display_text'));
        die();
    }
}
