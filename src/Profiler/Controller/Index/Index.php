<?php

namespace Mirasvit\Profiler\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Mirasvit\Profiler\Controller\Index
{
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        return $resultPage;
    }
}
