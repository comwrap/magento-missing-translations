<?php

namespace Comwrap\TranslatedPhrases\Model\Filesystem;

class DirectoryRegistry
{
    /**
     * IgnoredRegistry constructor.
     * @param array $directories
     */
    public function __construct(
        array $directories = [],
        array $ignoredMagentoModules = [],
        array $ignoredSubDirectories = []
    ) {
        $this->directories = $directories;
        $this->ignoredMagentoModules = $ignoredMagentoModules;
        $this->ignoredSubDirectories = $ignoredSubDirectories;
    }

    /**
     * @return array
     */
    public function getDirectories()
    {
        return $this->directories;
    }

    /**
     * @return array
     */
    public function getIgnoredSubDirectories()
    {
        return array_merge($this->ignoredMagentoModules, $this->ignoredSubDirectories);
    }
}
