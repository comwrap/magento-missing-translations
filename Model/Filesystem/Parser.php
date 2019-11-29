<?php

namespace Comwrap\TranslatedPhrases\Model\Filesystem;

use Comwrap\TranslatedPhrases\Model\Filesystem\Parser\ParserInterface;

class Parser
{
    /** @var DirectoryRegistry */
    private $directoryRegistry;

    /** @var array \Comwrap\TranslatedPhrases\Model\Filesystem\Parser\ParserInterface[] */
    private $parserAgents;

    /** @var array */
    private $phrases = [];

    /**
     * Parser constructor.
     * @param DirectoryRegistry $directoryRegistry
     * @param array $parserAgents
     */
    public function __construct(
        DirectoryRegistry $directoryRegistry,
        array $parserAgents = []
    ) {
        $this->parserAgents = $parserAgents;
        $this->directoryRegistry = $directoryRegistry;
    }

    /**
     * @return array
     */
    public function getPhrases()
    {
        /** @var ParserInterface $parserAgent */
        foreach ($this->parserAgents as $parserAgent) {
            foreach ($this->directoryRegistry->getDirectories() as $dir) {
                $this->phrases = array_merge($this->phrases, array_diff($parserAgent->getPhrases($dir), $this->phrases));
            }
        }

        return $this->phrases;
    }
}
