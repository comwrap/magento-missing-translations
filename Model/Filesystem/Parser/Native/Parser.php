<?php

namespace Comwrap\TranslatedPhrases\Model\Filesystem\Parser\Native;

use Comwrap\TranslatedPhrases\Model\Filesystem\Parser\Native\FilesCollector as ExtendedFilesCollector;
use Magento\Setup\Module\I18n;

class Parser extends I18n\Parser\Parser
{
    /**
     * @var ExtendedFilesCollector
     */
    protected $extendedFilesCollector;

    public function __construct(
        I18n\FilesCollector $filesCollector,
        ExtendedFilesCollector $extendedFilesCollector,
        I18n\Factory $factory
    ) {
        parent::__construct($filesCollector, $factory);

        $this->extendedFilesCollector = $extendedFilesCollector;
    }

    /**
     * @param array $parseOptions
     * @param $excluded
     * @return array
     */
    public function parseUsingExclusions(array $parseOptions, $excluded)
    {
        $this->_validateOptions($parseOptions);

        foreach ($parseOptions as $typeOptions) {
            $this->_parseByTypeOptionsUsingExclusions($typeOptions, $excluded);
        }
        return $this->_phrases;
    }

    /**
     * @param $options
     * @param $excluded
     */
    protected function _parseByTypeOptionsUsingExclusions($options, $excluded)
    {
        foreach ($this->_getFilesUsingExclusions($options, $excluded) as $file) {
            $adapter = $this->_adapters[$options['type']];
            $adapter->parse($file);

            foreach ($adapter->getPhrases() as $phraseData) {
                $this->_addPhrase($phraseData);
            }
        }
    }

    /**
     * @param $options
     * @param $excluded
     * @return array
     */
    protected function _getFilesUsingExclusions($options, $excluded)
    {
        $fileMask = isset($options['fileMask']) ? $options['fileMask'] : '';

        return $this->extendedFilesCollector->getFiles($options['paths'], $excluded, $fileMask);
    }
}
