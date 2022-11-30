<?php

namespace Erikgreasy\WpAdvancedForms;

use Illuminate\Validation\Factory as ValidationFactory;

abstract class FormComponent
{
    public bool $onlyAdmin = false;
    public string $submitUrl;
    public string $hook;
    public string $hookNopriv;
    public bool $usesAjax = false;
    protected ValidationFactory $validator;

    public function __construct()
    {
        if($this->usesAjax) {
            $this->submitUrl = \admin_url('admin-ajax.php');
            $this->hook = 'wp_ajax_' . $this->actionName();
            $this->hookNopriv = 'wp_ajax_nopriv_' . $this->actionName();
        } else {
            $this->submitUrl = \admin_url('admin-post.php');
            $this->hook = 'admin_post_' . $this->actionName();
            $this->hookNopriv = 'admin_post_nopriv_' . $this->actionName();
        }
    
        $this->validator = WpAdvancedForms::getInstance()->getValidationFactory();
    }

    /**
     * Function that inits all required WP hooks for catching form
     * submissions. This function is implicitly ran for all forms,
     * that are registered inside WpAdvancedForms::load() function.
     */
    public function register(): void
    {   
        \add_action($this->hook, function() {
            $this->handleSubmit();   
        });

        if (! $this->onlyAdmin) {
            \add_action($this->hookNopriv, function() {
                $this->handleSubmit();
            });
        }
    }

    /**
     * Return action input required by WP to catch which handling
     * function should run after submit. This is because all submissions
     * go to same endpoint. This hidden input is what differentiate them.
     */
    public function renderActionInput(): string
    {
        return <<<HTML
            <input type="hidden" name="action" value="{$this->actionName()}" />
        HTML;
    }

    /**
     * Required form classes, for working ajax, styles etc.
     */
    public function classes(): string
    {
        $classList = '';

        if($this->usesAjax) {
            $classList .= ' advanced-forms-ajax';
        }

        return <<<HTML
            class="$classList"
        HTML;
    }

    /**
     * This is where we land after form submission.
     */
    abstract public function handleSubmit();

    /**
     * Define unique action name, for WP to decide which handling
     * callback should be called.
     */
    abstract public function actionName(): string;
}
