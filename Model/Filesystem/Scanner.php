<?php

namespace Comwrap\TranslatedPhrases\Model\Filesystem;

class Scanner
{
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
                $this->getDirContents($path, $results);
                $results[] = $path;
            }
        }

        return $results;
    }
}
