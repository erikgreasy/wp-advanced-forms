# WP Advanced Forms - Custom WordPress forms made easier 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/erikgreasy/wp-advanced-forms.svg?style=flat-square)](https://packagist.org/packages/erikgreasy/wp-advanced-forms)

Advanced forms provide a convenient way to create custom forms in WordPress by making typical form tasks like validation easier.

## Current batteries included
- ability to use laravel validation
- easy way to config your form without hassle of repeating WP action key, ugly WP hooks callbacks for handling forms and more

## Installation

You can install the package via composer:

```bash
composer require erikgreasy/wp-advanced-forms
```

## Usage
Create your forms classes extending the base FormComponent class. Example form class:
```PHP
<?php

namespace App\Forms;

use Erikgreasy\WpAdvancedForms\FormComponent;

class ContactForm extends FormComponent
{
    public bool $usesAjax = true;

    public function handleSubmit()
    {
        // This is where we handle our form.
        // We can use provided laravel validator
        $validator = $this->validator->make($_POST, [
            'name' => 'required'
        ]);

        if($validator->fails()) {
            wp_send_json($validator->errors());
        }

        wp_send_json([
            'message' => 'Success'
        ]);
    }

    public function actionName(): string
    {
        return 'contact_form';
    }
}
```

Register all your forms in functions.php, or in the plugin:
```php
WpAdvancedForms::load([
    ContactForm::class,
]);
```

Now you can render your forms with single source of truth based in your form class:
```PHP
<?php
$form = \Erikgreasy\WpAdvancedForms\WpAdvancedForms::getForm(
    \App\Forms\ContactForm::class
);
?>

{!! $form->openForm() !!}
    {!! $form->renderActionInput() !!}
    
    <input type="text" name="name">

    <button>Submit</button>
{!! $form->closeForm() !!}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
