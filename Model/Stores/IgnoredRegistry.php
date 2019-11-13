<?php

namespace Comwrap\TranslatedPhrases\Model\Stores;

class IgnoredRegistry
{
    /**
     * IgnoredRegistry constructor.
     * @param array $ignoredLocales
     */
    public function __construct(
        array $ignoredLocales = []
    ) {
        $this->ignoredLocales = $ignoredLocales;
    }

    /**
     * Receiev
     *
     * @return mixed
     * @throws \Exception
     */
    public function getLocales()
    {
        return $this->ignoredLocales;
    }
}
