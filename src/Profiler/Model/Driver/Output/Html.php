<?php
namespace Mirasvit\Profiler\Model\Driver\Output;

use Magento\Framework\Profiler\Driver\Standard\Stat;
use Magento\Framework\Profiler\Driver\Standard\OutputInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Profiler;

class Html implements OutputInterface
{
    /**
     * {@inheritdoc}
     */
    public function display(Stat $stat)
    {
        Profiler::start(__METHOD__);
        $objectManager = ObjectManager::getInstance();

        /** @var \Mirasvit\Profiler\Model\Config $config */
        $config = $objectManager->get('\Mirasvit\Profiler\Model\Config');

        if (!$config->isEnabled()) {
            return;
        }

        /** @var \Magento\Framework\View\LayoutInterface $layout */
        $layout = $objectManager->create('\Magento\Framework\View\LayoutInterface');

        $storage = $objectManager->get('\Mirasvit\Profiler\Model\Storage');
        $storage->dump();
        $storage->save();

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';

        if (!$isAjax) {
            echo $layout->createBlock('\Mirasvit\Profiler\Block\Container')
                ->toHtml();
        }

        Profiler::stop(__METHOD__);
    }
}