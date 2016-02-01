<?php
namespace Mirasvit\Profiler\Block\Storage;

use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Magento\Framework\View\Element\Template;

class View extends Template
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
    public function getMeta()
    {
        $this->storage->load($this->getRequest()->getParam('file'));

        return $this->storage->loadMeta($this->getRequest()->getParam('file'));
    }
}