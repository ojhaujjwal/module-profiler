<?php
namespace Mirasvit\Profiler\Model\Profile;

use Magento\Framework\App\ResourceConnection;

class Database extends AbstractProfile
{
    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

    public function __construct(
        ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * {@inheritdoc}
     */
    public function dump()
    {
        /** @var \Zend_Db_Profiler_Query $profile */
        foreach ($this->getProfiler()->getQueryProfiles() as $profile) {
            $this->data[] = [
                'query'             => $profile->getQuery(),
                'query_type'        => $profile->getQueryType(),
                'query_params'      => $profile->getQueryParams(),
                'elapsed_secs'      => $profile->getElapsedSecs(),
                'started_microtime' => $profile->getStartedMicrotime(),
            ];
        }

        $this->meta = [
            'total_num_queries'  => $this->getProfiler()->getTotalNumQueries(),
            'total_elapsed_secs' => $this->getProfiler()->getTotalElapsedSecs(),
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function getQueryProfiles()
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getTotalNumQueries()
    {
        return $this->meta['total_num_queries'];
    }

    /**
     * @return float
     */
    public function getTotalElapsedSecs()
    {
        return $this->meta['total_elapsed_secs'];
    }

    /**
     * @return \Zend_Db_Profiler
     */
    protected function getProfiler()
    {
        return $this->resourceConnection->getConnection('read')
            ->getProfiler();
    }
}