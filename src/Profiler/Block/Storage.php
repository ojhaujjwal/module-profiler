<?php
namespace Mirasvit\Profiler\Block;

use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Magento\Framework\View\Element\Template;

class Storage extends Template
{
    public function __construct(
        TemplateContext $templateContext,
        \Mirasvit\Profiler\Model\Storage $storage,
        array $data = []
    ) {
        $this->storage = $storage;

        parent::__construct($templateContext, $data);
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->storage->ls();
    }
}