<?php

namespace Comwrap\TranslatedPhrases\Model\Filesystem\Parser\Native;

class DirectoryFilter extends \RecursiveFilterIterator
{
    /**
     * @var array
     */
    protected $exclude;

    /**
     * DirectoryFilter constructor.
     * @param RecursiveDirectoryIterator $iterator
     * @param array $exclude
     */
    public function __construct(
        $iterator,
        array $exclude
    ) {
        parent::__construct($iterator);
        $this->exclude = $exclude;
    }

    /**
     * @return bool
     */
    public function accept()
    {
        return !($this->matchesExcluded($this->getFilename()));
    }

    /**
     * @return DirectoryFilter
     */
    public function getChildren()
    {
        return new DirectoryFilter($this->getInnerIterator()->getChildren(), $this->exclude);
    }

    /**
     * @param $fileName
     * @return bool
     */
    private function matchesExcluded($fileName)
    {
        foreach ($this->exclude as $excludable) {
            if (preg_match("/{$excludable}/i", $fileName)) {
                return true;
            }
        }

        return false;
    }
}
