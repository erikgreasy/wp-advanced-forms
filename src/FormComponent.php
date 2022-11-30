<?php

namespace Erikgreasy\WpAdvancedForms;

abstract class FormComponent
{
    public string $action;
    public bool $onlyAdmin = false;
    public string $submitUrl;

    public function __construct()
    {
        $this->submitUrl = \admin_url('admin-post.php');
    }

    public function register()
    {
        \add_action("admin_post_{$this->action}", [$this, 'handleSubmit']);

        if (! $this->onlyAdmin) {
            \add_action("admin_post_nopriv_{$this->action}", [$this, 'handleSubmit']);
        }
    }

    abstract public function handleSubmit();
}
