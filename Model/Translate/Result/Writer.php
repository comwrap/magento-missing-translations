<?php

namespace Comwrap\TranslatedPhrases\Model\Translate\Result;

use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;

class Writer
{
    /** @var string  */
    const FILENAME_PREFIX = 'non-translated-phrases';

    /** @var string  */
    const FILENAME_SUFFIX = '.list';

    /** @var string  */
    const DATE_FORMAT = 'Y-m-d-H-i';

    const SEPARATOR = '-';

    /** @var Filesystem */
    private $filesystem;

    public function __construct(
        Filesystem $filesystem
    ) {
        $this->filesystem = $filesystem;
    }

    /**
     * @param string $list
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function writeList($list)
    {
        $media = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $media->writeFile(
            self::FILENAME_PREFIX . self::SEPARATOR . date(self::DATE_FORMAT) . self::FILENAME_SUFFIX,
            implode("\n", $list)
        );
    }
}
