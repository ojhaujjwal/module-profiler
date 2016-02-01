<?php
namespace Mirasvit\Profiler\Model;

use Symfony\Component\Yaml\Dumper as YamlDumper;
use Symfony\Component\Yaml\Parser as YamlParser;
use Magento\Framework\Profiler;

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

        foreach (glob($this->getPath() . "*.meta.yaml") as $filename) {
            $result[$filename] = $this->loadMeta($filename);
        }

        return $result;
    }

    /**
     * @return $this
     */
    public function dump()
    {
        Profiler::start(__METHOD__);

        foreach ($this->pool->getProfiles() as $code => $profile) {
            $profile->dump();
        }

        Profiler::stop(__METHOD__);

        return $this;
    }

    /**
     * @return $this
     */
    public function save()
    {
        $filename = microtime(true);

        $dataFile = $this->getPath() . $filename . '.data.yaml';
        $metaFile = $this->getPath() . $filename . '.meta.yaml';

        $data = [];
        $meta = [
            'url'       => "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}",
            'data_file' => $dataFile,
            'time'      => microtime(true),
        ];

        foreach ($this->pool->getProfiles() as $code => $profile) {
            $data[$code] = $profile->getData();
            $meta[$code] = $profile->getMeta();
        }

        $dumper = new YamlDumper();

        file_put_contents($dataFile, $dumper->dump($data, 10));
        file_put_contents($metaFile, $dumper->dump($meta, 10));

        return $this;
    }

    public function load($file)
    {
        $meta = $this->loadMeta($file);

        $dataFile = $meta['data_file'];

        $yaml = file_get_contents($dataFile);

        $data = (new YamlParser())->parse($yaml);

        foreach ($this->pool->getProfiles() as $code => $profile) {
            $profile->load($meta[$code], $data[$code]);
        }
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