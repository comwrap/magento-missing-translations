<?php

namespace Comwrap\TranslatedPhrases\Model\Filesystem;

use Comwrap\TranslatedPhrases\Helper\Configuration;

class Scanner
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * Scanner constructor.
     * @param Configuration $configuration
     */
    public function __construct(
        Configuration $configuration
    ) {
        $this->configuration = $configuration;
    }

    /**
     * Files collector
     *
     * @param string $dir
     * @param array $results
     * @return array
     */
    public function getDirContents($dir, &$results = [])
    {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } elseif ($value != "." && $value != "..") {
                if ($this->configuration->skipBackendScanning() && strtolower($value) == 'adminhtml') {
                    continue;
                }
                $this->getDirContents($path, $results);
                $results[] = $path;
            }
        }

        return $results;
    }
}
