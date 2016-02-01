<?php
namespace Mirasvit\Profiler\Model\Profile;

class Magento extends AbstractProfile
{
    /**
     * {@inheritdoc}
     */
    public function dump()
    {
        foreach ($this->getStat()->getFilteredTimerIds() as $timerId) {
            $this->data[$timerId] = $this->getStat()->get($timerId);
        }

        return $this->data;
    }

    public function getTimers()
    {
        return $this->data;
    }

    /**
     * @return \Magento\Framework\Profiler\Driver\Standard\Stat
     */
    public function getStat()
    {
        return $_SERVER['MAGE_PROFILER_STAT'];
    }
}