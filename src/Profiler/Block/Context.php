<?php
namespace Mirasvit\Profiler\Block;

use Magento\Framework\App\ResourceConnection;

class Context
{
    /**
     * @var \Magento\Framework\Profiler\Driver\Standard\Stat
     */
    protected $profilerStat;

    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

    public function __construct(
        \Mirasvit\Profiler\Model\Profile\Magento $magentoProfile,
        \Mirasvit\Profiler\Model\Profile\Database $databaseProfile
    ) {
        $this->magentoProfile = $magentoProfile;
        $this->databaseProfile = $databaseProfile;
    }

    /**
     * @return \Mirasvit\Profiler\Model\Profile\Magento
     */
    public function getMagentoProfile()
    {
        return $this->magentoProfile;
    }

    /**
     * @return \Mirasvit\Profiler\Model\Profile\Database
     */
    public function getDatabaseProfile()
    {
        return $this->databaseProfile;
    }
}