<?php

namespace Comwrap\TranslatedPhrases\Model\Filesystem\Parser;

use Magento\Setup\Module\I18n\Dictionary\Options\ResolverFactory;
use Magento\Setup\Module\I18n\Parser\Parser;
use Magento\Setup\Module\I18n\Parser\Adapter\Php\Tokenizer\PhraseCollector;
use Magento\Setup\Module\I18n\Parser\Adapter\Php\Tokenizer;
use Magento\Setup\Module\I18n\Parser\Adapter\Php;
use Magento\Setup\Module\I18n\Parser\Adapter\Html;
use Magento\Setup\Module\I18n\Parser\Adapter\Js;
use Magento\Setup\Module\I18n\Parser\Adapter\Xml;

class Native implements ParserInterface
{
    /** @var ResolverFactory */
    private $resolverFactory;

    /** @var ParserInterface */
    private $parser;

    /** @var array */
    private $phrases = [];

    /**
     * Native constructor.
     * @param ResolverFactory $resolverFactory
     * @param Parser $parser
     */
    public function __construct(
        ResolverFactory $resolverFactory,
        Parser $parser
    ) {
        $this->resolverFactory = $resolverFactory;
        $this->parser = $parser;

        foreach ($this->prepareAdapters() as $type => $adapter) {
            $this->parser->addAdapter($type, $adapter);
        }
    }

    /**
     * @param $directory
     * @param bool $withContext
     * @return string[]
     */
    public function getPhrases($directory, $withContext = false)
    {
        /** @var  $optionResolver */
        $optionResolver = $this->resolverFactory->create($directory, $withContext);

        /** Parse */
        $this->parser->parse($optionResolver->getOptions());

        /** Get Phrases */
        return $this->phrasesToString($this->parser->getPhrases());
    }

    /**
     * @return array
     */
    private function prepareAdapters()
    {
        /** @var  $phraseCollector */
        $phraseCollector = new PhraseCollector(new Tokenizer());

        return [
            'php' => new Php($phraseCollector),
            'html' => new Html(),
            'js' => new Js(),
            'xml' => new Xml(),
        ];
    }

    /**
     * @param $phrases
     * @return string[]
     */
    private function phrasesToString($phrases)
    {
        /** @var string[] $result */
        $result = [];

        foreach ($phrases as $phrase) {
            $result[] = $phrase->getPhrase();
        }

        return $result;
    }
}

