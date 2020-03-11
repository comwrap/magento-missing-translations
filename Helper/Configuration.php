<?php

namespace Comwrap\TranslatedPhrases\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Configuration
{
    /** @var string  */
    const SKIP_ADMIN_CONFIG_PATH = 'dev/translated_phrases/skip_backend';

    /** @var string  */
    const TARGET_SENTENCES_CONFIG_PATH = 'dev/translated_phrases/target_sentences';

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /**
     * Configuration constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function skipBackendScanning()
    {
        return  $this->scopeConfig->getValue(self::SKIP_ADMIN_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function targetSentences()
    {
        return  $this->scopeConfig->getValue(self::TARGET_SENTENCES_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
}
