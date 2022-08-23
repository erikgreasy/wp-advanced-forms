<?php

namespace Erikgreasy\WpAdvancedForms;

class WpAdvancedForms
{
    public static function load(array $forms): void
    {
        foreach ($forms as $form) {
            (new $form())->register();
        }
    }
}
