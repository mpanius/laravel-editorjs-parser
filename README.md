# Laravel-Editor-Js-Parser

A simple editor.js html parser for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ixbtcom/laravel-editorjs-parser.svg?style=for-the-badge)](https://packagist.org/packages/ixbtcom/laravel-editorjs-parser)
[![Total Downloads](https://img.shields.io/packagist/dt/ixbtcom/laravel-editorjs-parser.svg?style=for-the-badge)](https://packagist.org/packages/ixbtcom/laravel-editorjs-parser)

## Features
- Render Editor.js output
- Custom block rendering

## Demo
You can can play with the demo [here](https://github.com/ixbtcom/laravel-editorjs-parser-demo)

## Installation

You can install the package via composer:

```bash
composer require ixbtcom/laravel-editorjs-parser
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-editorjs-parser-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-editorjs-parser-views"
```

## Usage

```php
use App\Models\Post;

$post = Post::find(1);
echo LaravelEditorJsParser::render($post->body, $template);
```

Defining An Accessor

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ixbtcom\LaravelEditorJsParser\Facades\LaravelEditorJsParser;

class Post extends Model
{
    public function getBodyAttribute()
    {
        return LaravelEditorJsParser::render($this->attributes['body'], 'default');
    }
}

$post = Post::find(1);
echo $post->body;
```

## Versioning

| Laravel         | Supported |
|-----------------| --------- |
| 10.x, 11.x, 12x | ✅ 2.x    |
| 9.x             | ✅ 1.1    |
| 8.x             | ✅ 1.0    |


## Credits
- [Mikhail Panyushkin](https://github.com/mpanius)
- [Al-Amin Firdows](https://github.com/alaminfirdows)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
