<?php

namespace Erikgreasy\WpAdvancedForms;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory as ValidationFactory;

class WpAdvancedForms
{
    private string $langDir;
    private ?ValidationFactory $validationFactory = null;
    private static ?self $instance = null;

    private function __construct()
    {
        $translationDir = $this->getLangDir();
        $fileLoader = new FileLoader(new Filesystem, $translationDir);
        $fileLoader->addNamespace('lang', $translationDir);
        $fileLoader->load('en', 'validation', 'lang');
        
        $translator = new Translator($fileLoader, 'en');
        
        $this->validationFactory = new ValidationFactory($translator);
    }

    /**
     * Singleton reriever
     */
    public static function getInstance(): self
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public static function load(array $forms): void
    {
        foreach ($forms as $form) {
            (new $form())->register();
        }
    }

    public static function setLangDir(string $langDir)
    {
        self::getInstance()->langDir = $langDir;
    }

    public function getValidationFactory()
    {
        return $this->validationFactory;
    }

    private function getLangDir(): string
    {
        if(isset($this->langDir)) {
            return $this->langDir;
        }

        return dirname(__DIR__) . '/lang';;
    }
}
