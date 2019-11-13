<?php

namespace Comwrap\TranslatedPhrases\Model\Translate;

use Magento\Framework\TranslateInterfaceFactory;
use Magento\Framework\Phrase\Renderer\TranslateFactory;

class Translator
{
    /**
     * @var \Magento\Framework\TranslateInterfaceFactory
     */
    private $translateFactory;

    /**
     * @var Magento\Framework\Phrase\Renderer\TranslateFactory
     */
    private $rendererFactory;

    /**
     * Translator constructor.
     * @param TranslateInterfaceFactory $translateFactory
     * @param TranslateFactory $rendererFactory
     */
    public function __construct(
        TranslateInterfaceFactory $translateFactory,
        TranslateFactory $rendererFactory
    ) {
        $this->translateFactory = $translateFactory;
        $this->rendererFactory = $rendererFactory;
    }

    /**
     * @param string $phrase
     * @param string $locale
     * @return string
     */
    public function getTranslation($phrase, $locale)
    {
        /** @var  $translator */
        $translator = $this->translateFactory->create();
        $translator->setLocale($locale);
        $translator->loadData();

        $renderer = $this->rendererFactory->create(['translator' => $translator]);
        \Magento\Framework\Phrase::setRenderer($renderer);

        $phrase = new \Magento\Framework\Phrase($phrase);

        return (string)$phrase;
    }
}
