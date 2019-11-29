<?php

namespace Comwrap\TranslatedPhrases\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Comwrap\TranslatedPhrases\Model\Stores\Collector as StoresCollector;
use Comwrap\TranslatedPhrases\Model\Filesystem\Parser as FileSystemParser;
use Comwrap\TranslatedPhrases\Model\Translate\Result\Builder as ResultBuilder;

class DetectNonTranslated extends Command
{
    /** @var StoresCollector */
    private $storesCollector;

    /** @var FileSystemCollector */
    private $fileSystemCollector;

    /** @var ResultBuilder */
    private $resultBuilder;

    /**
     * DetectNonTranslated constructor.
     * @param StoresCollector $storesCollector
     * @param FileSystemParser $fileSystemCollector
     * @param ResultBuilder $resultBuilder
     */
    public function __construct(
        StoresCollector $storesCollector,
        FileSystemParser $fileSystemCollector,
        ResultBuilder $resultBuilder
    ) {
        $this->storesCollector = $storesCollector;
        $this->fileSystemCollector = $fileSystemCollector;
        $this->resultBuilder = $resultBuilder;
        parent::__construct();
    }

    /**
     * Configure the command
     */
    protected function configure()
    {
        $this->setName('i18n:non-translated:detect');
        $this->setDescription('Detect non-translated phrases.');

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** Collect locales */
        $locales = $this->storesCollector->collectLocales();

        /** Collect phrases */
        $phrases = $this->fileSystemCollector->getPhrases();

        /** Build list */
        $this->resultBuilder->buildList($locales, $phrases);
    }
}
