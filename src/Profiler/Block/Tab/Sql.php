<?php
namespace Mirasvit\Profiler\Block\Tab;

use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Magento\Framework\View\Element\Template;
use Mirasvit\Profiler\Block\Context;

class Sql extends Template implements TabInterface
{
    protected $_template = 'tab/sql.phtml';

    /**
     * @var Context
     */
    protected $context;

    public function __construct(
        Context $context,
        TemplateContext $templateContext,
        array $data = []
    ) {
        $this->context = $context;

        parent::__construct($templateContext, $data);
    }


    public function getLabel()
    {
        return __('Sql');
    }

    public function isEnabled()
    {
        return is_array($this->getProfile()->getQueryProfiles());
    }

    /**
     * @return \Mirasvit\Profiler\Model\Profile\Database
     */
    public function getProfile()
    {
        return $this->context->getDatabaseProfile();
    }

    /**
     * @return array
     */
    public function getSlowQueries()
    {
        $queries = [];

        /** @var  \Zend_Db_Profiler_Query $query */
        foreach ($this->getDbProfiler()->getQueryProfiles() as $queryId => $query) {
            $queries[$queryId] = $query->getElapsedSecs();
        }

        arsort($queries);
        $queries = array_slice($queries, 0, 5, true);

        return $queries;
    }
}