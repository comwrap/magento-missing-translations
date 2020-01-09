<?php

namespace Comwrap\TranslatedPhrases\Model\Translate;

use Magento\Framework\TranslateInterfaceFactory;
use Magento\Framework\Phrase\Renderer\TranslateFactory;
use Comwrap\TranslatedPhrases\Model\Stores\Collector as StoresCollector;
use Magento\Framework\App\State;

class Translator
{
    /** @var array */
    private $renderers;

    /**
     * Translator constructor.
     * @param TranslateInterfaceFactory $translateFactory
     * @param TranslateFactory $rendererFactory
     * @param StoresCollector $storesCollector
     */
    public function __construct(
        State $appState,
        TranslateInterfaceFactory $translateFactory,
        TranslateFactory $rendererFactory,
        StoresCollector $storesCollector
    ) {
        $appState->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);

        foreach ($storesCollector->collectLocales() as $locale) {
            /** @var  $translator */
            $translator = $translateFactory->create();
            $translator->setLocale($locale);
            $translator->loadData();
            $this->renderers[$locale] = $rendererFactory->create(['translator' => $translator]);
        }
    }

    /**
     * @param string $phrase
     * @param string $locale
     * @return string
     */
    public function getTranslation($phrase, $locale)
    {
        \Magento\Framework\Phrase::setRenderer($this->renderers[$locale]);
        $phrase = new \Magento\Framework\Phrase($phrase);
        return (string)$phrase;
    }
}
