<?php

namespace Ixbtcom\LaravelEditorJsParser\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Ixbtcom\LaravelEditorJsParser\LaravelEditorJsParser
 */
class LaravelEditorJsParser extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-editorjs-parser';
    }
}
