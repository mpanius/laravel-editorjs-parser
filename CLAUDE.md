# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Repository Overview

Laravel Editor.js Parser - A Laravel package that renders Editor.js block data into HTML using customizable Blade templates. This library provides seamless integration between Editor.js and Laravel applications with support for multiple template themes.

## Key Commands

```bash
# Install dependencies
composer install

# Run tests
composer test
# or
vendor/bin/phpunit

# Run specific test suite
vendor/bin/phpunit --testsuite Unit
vendor/bin/phpunit --testsuite Feature

# Run single test
vendor/bin/phpunit tests/Unit/RenderTest.php
vendor/bin/phpunit --filter testMethodName

# Publish package assets (when using as dependency)
php artisan vendor:publish --tag="laravel-editorjs-parser-config"
php artisan vendor:publish --tag="laravel-editorjs-parser-views"
```

## Architecture & Structure

### Core Components

1. **LaravelEditorJsParser** (`src/LaravelEditorJsParser.php`): Main parser class with two methods:
   - `render()`: Returns rendered HTML as a single string
   - `renderBlocks()`: Returns array of rendered blocks with their data and final sizes

2. **Service Provider** (`src/LaravelEditorJsParserServiceProvider.php`): Registers the package, publishes config and views

3. **Facade** (`src/Facades/LaravelEditorJsParser.php`): Provides static access to parser methods

### Template System

The package uses a hierarchical template system located in `resources/views/`:

- **default/**: Standard HTML templates for all Editor.js block types
- **amp/**: AMP-optimized templates (limited blocks)
- **turbo/**: Yandex Turbo templates
- **zen/**: Yandex Zen templates

Template resolution follows this hierarchy:
1. Check for template in specified directory (e.g., `amp/image.blade.php`)
2. Fall back to default template (e.g., `default/image.blade.php`)
3. Use `default/not-found.blade.php` if block type is unsupported

### Supported Block Types

- paragraph, header/heading, list, checklist, quote
- code, delimiter, raw, table
- image, gallery, embed, link

### Integration with Editor.js

The package uses `codex-team/editor.js` v2.0.7 for parsing JSON data. Block types are converted to kebab-case for template matching (e.g., `myBlock` → `my-block.blade.php`).

## Testing

Tests are organized into:
- **Unit Tests** (`tests/Unit/`): Core rendering functionality
- **Feature Tests** (`tests/Feature/Blocks/`): Individual block type rendering

The package uses Orchestra Testbench for Laravel package testing.