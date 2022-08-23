
[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# WP Advanced Forms - Custom WordPress forms made easier 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/erikgreasy/wp-advanced-forms.svg?style=flat-square)](https://packagist.org/packages/erikgreasy/wp-advanced-forms)
[![Tests](https://github.com/erikgreasy/wp-advanced-forms/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/erikgreasy/wp-advanced-forms/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/erikgreasy/wp-advanced-forms.svg?style=flat-square)](https://packagist.org/packages/erikgreasy/wp-advanced-forms)

This is where your description should go. Try and limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require erikgreasy/wp-advanced-forms
```

## Usage
Register all your forms in functions.php, or in the plugin:
```php
WpAdvancedForms::load([
    TestForm::class,
    ContactForm::class
]);
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
