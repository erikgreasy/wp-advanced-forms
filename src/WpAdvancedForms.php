<?php

namespace Erikgreasy\WpAdvancedForms;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Erikgreasy\WpAdvancedForms\FormComponent;
use Illuminate\Validation\Factory as ValidationFactory;

class WpAdvancedForms
{
    private ?ValidationFactory $validationFactory = null;
    private static ?self $instance = null;

    /** @var FormComponent[] */
    private array $forms = [];

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
        $instance = self::getInstance();

        foreach ($forms as $form) {
            if(array_key_exists($form, $instance->forms)) {
                throw new \RuntimeException("Form $form already registered. Dont you load this form multiple times?");
            }

            $formInstance = new $form;
            $instance->forms[$form] = $formInstance;
            $formInstance->register();
        }
    }

    public function getValidationFactory()
    {
        return $this->validationFactory;
    }

    public static function getForm(string $className): FormComponent
    {
        $instance = self::getInstance();

        if(!array_key_exists($className, $instance->forms)) {
            throw new \RuntimeException("Requested form $className instance not found. Did you load it?");
        }
        
        return $instance->forms[$className];
    }

    public function getLangDir(): string
    {
        $langDir = apply_filters('wp_advanced_forms_lang_dir', dirname(__DIR__) . '/lang');

        return $langDir;
    }
}
