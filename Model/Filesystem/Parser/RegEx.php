<?php

namespace Comwrap\TranslatedPhrases\Model\Filesystem\Parser;

use Comwrap\TranslatedPhrases\Model\Filesystem\Scanner;

class RegEx implements ParserInterface
{
    /** @var string  */
    const REGEX_PRIMARY = '/(__\(.*?\'\))/';

    /** @var string  */
    const REGEX_SECONDARY = '/(__\(.*?\'\,)/';

    /** @var array  */
    const EXCLUDE_PATTERNS = ["')"];

    /** @var string  */
    const PHRASE_END_WITHOUT_PARAMS = "'";

    /** @var string  */
    const PHRASE_END_WITH_PARAMS = "',";

    /** @var int  */
    const OFFSET_START = 4;

    /** @var int  */
    const OFFEST_END = 2;

    /** @var array */
    private $phrases = [];

    /** @var Scanner */
    private $scanner;

    /**
     * Collector constructor.
     * @param \Comwrap\TranslatedPhrases\Model\Filesystem\Scanner $scanner
     */
    public function __construct(
        Scanner $scanner
    ) {
        $this->scanner = $scanner;
    }

    /**
     * @param string $directory
     * @param bool $withContext
     * @return array
     */
    public function getPhrases($directory, $withContext = false)
    {
        $files = $this->scanner->getDirContents($directory);
        foreach ($files as $file) {
            $this->processFile($file);
        }

        return $this->phrases;
    }

    /**
     * @param string $file
     */
    private function processFile($file)
    {
        $fn = fopen($file, "r");
        while (! feof($fn)) {
            $line = fgets($fn);
            $this->processLine($line, self::REGEX_PRIMARY);
            $this->processLine($line, self::REGEX_SECONDARY);
        }

        fclose($fn);
    }

    /**
     * @param string $line
     * @param string $regEx
     */
    private function processLine($line, $regEx)
    {
        do {
            preg_match($regEx, $line, $matches);
            if (is_array($matches) && isset($matches[0])) {
                $fullPhrase = $matches[0];
                /** Clean */
                $phrase = $this->cleanPhrase($fullPhrase, $regEx);
                /** Add */
                $this->addPhrase($phrase);
                /** Move the line */
                $line = substr($line, strpos($line, $fullPhrase) + strlen($fullPhrase));
            }
        } while (sizeof($matches) > 0);
    }

    /**
     * @param string $fullPhrase
     * @param string $regEx
     * @return false|string|null
     */
    private function cleanPhrase($fullPhrase, $regEx)
    {
        if ($regEx == self::REGEX_PRIMARY) {
            return $this->cleanPhraseWithoutParams($fullPhrase);
        }

        if ($regEx == self::REGEX_SECONDARY) {
            return $this->cleanPhraseWithParams($fullPhrase);
        }
    }

    /**
     * Phrase type without params
     *
     * @param string $phrase
     * @return false|string|null
     */
    private function cleanPhraseWithoutParams($phrase)
    {
        if ($cleanedWithParams = $this->cleanPhraseWithParams($phrase)) {
            return $cleanedWithParams;
        }

        $charArray = str_split($phrase);

        if ($charArray[self::OFFSET_START - 1] == self::PHRASE_END_WITHOUT_PARAMS) {
            if ($charArray[strlen($phrase) - self::OFFEST_END] == self::PHRASE_END_WITHOUT_PARAMS) {
                $phrase = substr(
                    $phrase,
                    self::OFFSET_START,
                    strlen($phrase) - (self::OFFSET_START + self::OFFEST_END)
                );

                return $phrase;
            }
        }

        return null;
    }

    /**
     * Phrase type with Params
     *
     * @param string $phrase
     * @return false|string|null
     */
    private function cleanPhraseWithParams($phrase)
    {
        if (stripos($phrase, self::PHRASE_END_WITH_PARAMS)) {
            $phrase = substr(
                $phrase,
                self::OFFSET_START,
                stripos($phrase, self::PHRASE_END_WITH_PARAMS) - self::OFFSET_START
            );

            foreach (self::EXCLUDE_PATTERNS as $pattern) {
                if (strpos($phrase, $pattern) > 0) {
                    return null;
                }
            }

            return $phrase;
        }

        return null;
    }

    /**
     * @param string $phrase
     */
    private function addPhrase($phrase)
    {
        if ($phrase != null && !in_array($phrase, $this->phrases)) {
            $this->phrases[] = $phrase;
        }
    }
}
