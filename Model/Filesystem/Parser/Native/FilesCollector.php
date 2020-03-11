<?php

namespace Comwrap\TranslatedPhrases\Model\Filesystem\Parser\Native;

class FilesCollector
{
    /**
     * Get files
     *
     * @param array $paths
     * @param bool $fileMask
     * @return array
     */
    public function getFiles(array $paths, $excluded, $fileMask = false)
    {
        $files = [];
        foreach ($paths as $path) {
            foreach ($this->getIterator($path, $excluded, $fileMask) as $file) {
                $files[] = (string)$file;
            }
        }
        sort($files);
        return $files;
    }

    /**
     * Get files iterator
     *
     * @param string $path
     * @param array $excluded
     * @param bool $fileMask
     * @return \RecursiveIteratorIterator|\RegexIterator
     * @throws \InvalidArgumentException
     */
    protected function getIterator($path, $excluded, $fileMask = false)
    {
        try {
            $directoryIterator = new \RecursiveDirectoryIterator(
                $path,
                \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS | \FilesystemIterator::FOLLOW_SYMLINKS
            );
            $iterator = new \RecursiveIteratorIterator(new DirectoryFilter($directoryIterator, $excluded));
        } catch (\UnexpectedValueException $valueException) {
            throw new \InvalidArgumentException(sprintf('Cannot read directory for parse phrase: "%s".', $path));
        }
        if ($fileMask) {
            $iterator = new \RegexIterator($iterator, $fileMask);
        }
        return $iterator;
    }
}