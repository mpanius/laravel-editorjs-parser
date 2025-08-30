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

### New: renderBlocksdata()

Новый метод не ломает существующий API и возвращает массив обогащённых блоков.

```php
use Ixbtcom\LaravelEditorJsParser\LaravelEditorJsParser;

$parser = app(LaravelEditorJsParser::class);

// $blocks — это массив Editor.js (например, $editor->getBlocks())
$result = $parser->renderBlocksdata($blocks, ['zen', 'default'], [
    'with_gallery_link' => true, // обёртка <a href="original" data-gallery>
]);

// Каждый элемент:
// [
//   'html' => '<p>...</p>',
//   'type' => 'paragraph',
//   'data' => [ ... возможно обогащено ... ],
//   'length' => 123
// ]
```

### Поиск шаблонов (template_dir)

- `template_dir` может быть строкой или массивом: `['zen', 'xml']`.
- Резолвим по порядку, затем fallback на `default`.
- Для блока `image` используется цепочка `image-responsive` → `image-light` → `image`.

### Responsive изображения

- Для блоков `image` парсер обогащает `data['responsive']` полями: `src`, `srcset`, `sizes`, `original`, `link_wrapped`.
- Источник `srcset`:
  1) `Media::getSrcset()` из модели `Ixbtcom\Common\Models\Media` (CDN/on-the-fly);
  2) если нет — fallback через `Ixbtcom\Common\Services\ImageService` и размеры из `config('common.images.sizes.by_project.{project|all}.content_images.responsive')`.
- Дефолтный `sizes`: `(max-width: 768px) 100vw, 768px` (можно переопределить в данных блока/опциях).

### Совместимость

- Существующие методы `render()` и `renderBlocks()` не изменены.
- Новые возможности не требуют миграций БД и не создают файловых конверсий — все URL формируются на лету.

### Пример Blade-шаблона: image-responsive

Шаблон добавлен в `resources/views/default/image-responsive.blade.php` и принимает `data['responsive']`.

```blade
<img
  src="{{ $data['responsive']['src'] }}"
  @if(!empty($data['responsive']['srcset'])) srcset="{{ $data['responsive']['srcset'] }}" @endif
  sizes="{{ $data['responsive']['sizes'] ?? '(max-width: 768px) 100vw, 768px' }}"
  loading="lazy" decoding="async" />
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
