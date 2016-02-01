<?php
namespace Mirasvit\Profiler\Model\Profile;

abstract class AbstractProfile
{
    /**
     * @var array
     */
    protected $meta = [];

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @return $this
     */
    public abstract function dump();

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param array $meta
     * @param array $data
     * @return $this
     */
    public function load($meta = [], $data = [])
    {
        $this->meta = $meta;
        $this->data = $data;

        return $this;
    }
}