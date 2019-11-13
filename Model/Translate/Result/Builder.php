<?php

namespace Comwrap\TranslatedPhrases\Model\Translate\Result;

use Comwrap\TranslatedPhrases\Model\Translate\Translator;

class Builder
{
    /** @var string  */
    const SEPARATOR = ": ";

    /** @var Translator */
    private $translator;

    /**
     * Builder constructor.
     * @param Translator $translator
     */
    public function __construct(
        Translator $translator
    ) {
        $this->translator = $translator;
    }

    /**
     * @param array $locales
     * @param array $phrases
     * @return array
     */
    public function buildList($locales, $phrases)
    {
        $list = [];
        foreach ($locales as $locale) {
            foreach ($phrases as $phrase) {
                if ($phrase == $this->translator->getTranslation($phrase, $locale)) {
                    $list[] = $locale . self::SEPARATOR . $phrase;
                }
            }
        }

        return $list;
    }
}
