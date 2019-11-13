<?php

namespace Comwrap\TranslatedPhrases\Console;

use Magento\Framework\App\State;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Comwrap\TranslatedPhrases\Model\Filesystem\Collector as FileSystemCollector;
use Comwrap\TranslatedPhrases\Model\Stores\Collector as StoresCollector;
use Comwrap\TranslatedPhrases\Model\Translate\Result\Builder as ResultBuilder;
use Comwrap\TranslatedPhrases\Model\Translate\Result\Writer as ResultWriter;

class DetectNonTranslated extends Command
{
    /** @var Magento\Framework\App\State */
    private $appState;

    /** @var FileSystemCollector */
    private $fileSystemCollector;

    /** @var StoresCollector */
    private $storesCollector;

    /** @var ResultBuilder */
    private $resultBuilder;

    /** @var ResultWriter */
    private $resultWriter;

    /**
     * DetectNonTranslated constructor.
     * @param State $appState
     * @param FileSystemCollector $fileSystemCollector
     * @param StoresCollector $storesCollector
     * @param ResultBuilder $resultBuilder
     * @param ResultWriter $resultWriter
     */
    public function __construct(
        State $appState,
        FileSystemCollector $fileSystemCollector,
        StoresCollector $storesCollector,
        ResultBuilder $resultBuilder,
        ResultWriter $resultWriter
    ) {
        $this->appState = $appState;
        $this->fileSystemCollector = $fileSystemCollector;
        $this->storesCollector = $storesCollector;
        $this->resultBuilder = $resultBuilder;
        $this->resultWriter = $resultWriter;
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
        $this->appState->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);

        /** Collect locales */
        $locales = $this->storesCollector->collectLocales();

        /** Collect phrases */
        $phrases = $this->fileSystemCollector->collectPhrases();

        /** Build list */
        $list = $this->resultBuilder->buildList($locales, $phrases);

        /** Write results */
        $this->resultWriter->writeList($list);
    }
}
