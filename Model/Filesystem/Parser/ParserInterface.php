<?php

namespace Comwrap\TranslatedPhrases\Model\Filesystem\Parser;

interface ParserInterface
{
    /**
     * @param string $directory Path to the directory scanned, relative to magento root
     * @param array $excluded The subdirectories that should be excluded from scanning
     * @param boolean $withContext
     * @return array Array of strings
     */
    public function getPhrases($directory, $excluded, $withContext);
}