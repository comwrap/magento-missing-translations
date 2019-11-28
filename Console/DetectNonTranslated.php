<?php

namespace Comwrap\TranslatedPhrases\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Comwrap\TranslatedPhrases\Model\Filesystem\Collector as FileSystemCollector;
use Comwrap\TranslatedPhrases\Model\Stores\Collector as StoresCollector;
use Comwrap\TranslatedPhrases\Model\Translate\Result\Builder as ResultBuilder;
use Comwrap\TranslatedPhrases\Model\Translate\Result\Writer as ResultWriter;

class DetectNonTranslated extends Command
{
    /** @var FileSystemCollector */
    private $fileSystemCollector;

    /** @var StoresCollector */
    private $storesCollector;

    /** @var ResultBuilder */
    private $resultBuilder;

    /**
     * DetectNonTranslated constructor.
     * @param FileSystemCollector $fileSystemCollector
     * @param StoresCollector $storesCollector

     * @param ResultWriter $resultWriter
     */
    public function __construct(
        FileSystemCollector $fileSystemCollector,
        StoresCollector $storesCollector,
        ResultBuilder $resultBuilder
    ) {
        $this->fileSystemCollector = $fileSystemCollector;
        $this->storesCollector = $storesCollector;
        $this->resultBuilder = $resultBuilder;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('i18n:non-translated:detect');
        $this->setDescription('Detect non-translated phrases.');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** Collect locales */
        $locales = $this->storesCollector->collectLocales();

        /** Collect phrases */
        $phrases = $this->fileSystemCollector->collectPhrases();

        /** Build list */
        $this->resultBuilder->buildList($locales, $phrases);
    }
}
