<?php
namespace Mirasvit\Profiler\Model;

use Symfony\Component\Yaml\Dumper as YamlDumper;
use Symfony\Component\Yaml\Parser as YamlParser;

class Storage
{
    /**
     * @var Profile\Pool
     */
    protected $pool;

    public function __construct(
        Profile\Pool $profilePool
    ) {
        $this->pool = $profilePool;
    }

    public function ls()
    {
        $result = [];

        foreach (glob($this->getPath()."*.meta.yaml") as $filename) {
            $result[$filename] = $this->loadMeta($filename);
        }

        return $result;
    }

    public function dump()
    {
        $dump = [];
        $meta = [
            'url'  => "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}",
            'time' => microtime(true),
        ];

        foreach ($this->pool->getProfiles() as $code => $profile) {
            $dump[$code] = $profile->dump();
//            $meta[$code] = $profile->meta();
        }

        $dumper = new YamlDumper();

        $filename = microtime(true);

        $file = $this->getPath() . $filename . '.yaml';
        file_put_contents($file, $dumper->dump($dump, 10));

        $file = $this->getPath() . $filename . '.meta.yaml';
        file_put_contents($file, $dumper->dump($meta, 10));
    }

    public function load()
    {

    }

    /**
     * @param string $file
     * @return array
     */
    public function loadMeta($file)
    {
        $yaml = file_get_contents($file);

        return (new YamlParser())->parse($yaml);
    }

    public function getPath()
    {
        $path = BP . '/var/profiler/';
        if (!file_exists($path)) {
            mkdir($path);
        }

        return $path;
    }

}