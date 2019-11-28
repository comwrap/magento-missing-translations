<?php

namespace Comwrap\TranslatedPhrases\Model\Translate\Result;

use Comwrap\TranslatedPhrases\Model\Translate\Translator;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;

class Builder
{
    /** @var string  */
    const SEPARATOR_LINE = ": ";

    /** @var string  */
    const SEPARATOR_FILENAME = '-';

    /** @var string  */
    const FILENAME_PREFIX = 'non-translated-phrases';

    /** @var string  */
    const FILENAME_SUFFIX = '.list';

    /** @var string  */
    const DATE_FORMAT = 'Y-m-d-H-i';

    /** @var string  */
    const NEW_ROW = "\n";

    /** @var string  */
    const WRITE_MODE = 'a+';

    /** @var Translator */
    private $translator;

    /** @var Filesystem */
    private $filesystem;

    /**
     * Builder constructor.
     * @param Translator $translator
     */
    public function __construct(
        Translator $translator,
        Filesystem $filesystem
    ) {
        $this->translator = $translator;
        $this->filesystem = $filesystem;
    }

    /**
     * @param array $locales
     * @param array $phrases
     * @return array
     */
    public function buildList($locales, $phrases)
    {
        /** @var \FileSystem\Directory\WriteInterface $varDir */
        $varDir = $this->filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);

        /** @var string $fileName */
        $fileName = self::FILENAME_PREFIX
            . self::SEPARATOR_FILENAME
            . date(self::DATE_FORMAT)
            . self::FILENAME_SUFFIX;

        foreach ($locales as $locale) {
            foreach ($phrases as $phrase) {
                if ($phrase == $this->translator->getTranslation($phrase, $locale)) {
                    $varDir->writeFile(
                        $fileName, $locale . self::SEPARATOR_LINE . $phrase . self::NEW_ROW,
                        self::WRITE_MODE
                    );
                }
            }
        }
    }
}
