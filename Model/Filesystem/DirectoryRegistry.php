<?php

namespace Comwrap\TranslatedPhrases\Model\Filesystem;

class DirectoryRegistry
{
    /**
     * IgnoredRegistry constructor.
     * @param array $directories
     */
    public function __construct(
        array $directories = []
    ) {
        $this->directories = $directories;
    }

    /**
     * @return array
     */
    public function getDirectories()
    {
        return $this->directories;
    }
}
