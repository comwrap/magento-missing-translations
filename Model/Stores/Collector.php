<?php

namespace Comwrap\TranslatedPhrases\Model\Stores;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Collector
{
    /** @var string  */
    const CONFIGURATION_PATH = 'general/locale/code';

    /** @var array  */
    private $locales = [];

    /** @var IgnoredRegistry */
    private $ignoredRegistry;

    /** @var ScopeConfigInterface */
    private $config;

    /** @var StoreManagerInterface */
    private $storeManager;

    /**
     * Collector constructor.
     * @param IgnoredRegistry $ignoredRegistry
     * @param ScopeConfigInterface $config
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        IgnoredRegistry $ignoredRegistry,
        ScopeConfigInterface $config,
        StoreManagerInterface $storeManager
    ) {
        $this->ignoredRegistry = $ignoredRegistry;
        $this->config = $config;
        $this->storeManager = $storeManager;
    }

    /**
     * @return array
     */
    public function getLocales()
    {
        return $this->locales;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function collectLocales()
    {
        /** @var array $ignoredLocales */
        $ignoredLocales = $this->ignoredRegistry->getLocales();
        /** @var  $storeManagerDataList */
        $storeManagerDataList = $this->storeManager->getStores();

        foreach ($storeManagerDataList as $store) {
            $locale = $this->config->getValue(self::CONFIGURATION_PATH, ScopeInterface::SCOPE_STORE, $store->getID());
            if (!in_array(substr($locale, 0, 2), $ignoredLocales) &&
                !in_array($locale, $this->locales)
            ) {
                $this->locales[] = $locale;
            }
        }

        return $this->getLocales();
    }
}
