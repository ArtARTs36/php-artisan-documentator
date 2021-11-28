# Artisan Documentator

This package provides generate documentation about your app console commands.

## Installation

Run commands:

* `composer require --dev artarts36/artisan-documentator`
* `php artisan vendor:publish --provider="ArtARTs36\ArtisanDocumentator\Providers\ArtisanDocumentatorServiceProvider" --tag=config`

## Console commands

After installation, you can run command `php artisan command:doc {path}`. Example: `php artisan command:doc docs/command.md`

## Configuration

You can set command's namespaces in the file: `config/artisan_documentator.php` in section 'namespaces':

```php
    'namespaces' => [
        // 'namespace:' => 'title,
        // 'app:' => 'App Commands',
        // 'make:' => 'Laravel make Commands',
    ],
```

## Using in CI

In order to use generation in CI you need to specify your login and token in the file in the file: `config/artisan_documentator.php` in section 'git.remotes':
```php
    'git' => [
        'dir' => base_path(),
        'remote' => [
            'login' => 'my-name',
            'token' => env('ARTISAN_DOCUMENTATOR_GIT_REMOTE_TOKEN'),
        ],
        'commit' => [
            'message' => '[DOCS] auto-build console documentation',
        ],
    ],
```

Command call in your CI conf file:

`php artisan command:doc docs/command.md --ci`

### Command Description

Must fill property `description` in console commands for full documentation.

Use the [PHP CS Fixer rule](https://github.com/ArtARTs36/php-cs-fixer-good-fixers) `PhpCsFixerGoodFixers/laravel_command_no_empty_description` to prevent undescribed commands from entering your repository.  
