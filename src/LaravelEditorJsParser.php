<?php

namespace Ixbtcom\LaravelEditorJsParser;

use EditorJS\EditorJS;
use EditorJS\EditorJSException;
use Exception;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class LaravelEditorJsParser
{
    /**
     * Render blocks
     *
     * @param string $data
     * @return string
     * @throws Exception
     */
    public function render(string $data, $template_dir = 'default') : string
    {
        try {
            $configJson = json_encode(config('laravel-editorjs-parser.config') ?: []);

            $editor = new EditorJS($data, $configJson);

            $renderedBlocks = [];

            foreach ($editor->getBlocks() as $index => $block) {
                try {
                    $blockId = $block['id'] ?? "блок #{$index}";
                    $blockType = $block['type'] ?? 'unknown';
                    
                    $viewName = "laravel-editorjs-parser::{$template_dir}." . Str::snake($blockType, '-');

                    if (! View::exists($viewName)) {
                        if($template_dir === 'default') {
                            $viewName = "laravel-editorjs-parser::default.not-found";
                        } else {
                            $viewName = "laravel-editorjs-parser::default." . Str::snake($blockType, '-');
                            if(!View::exists($viewName)){
                                $viewName = "laravel-editorjs-parser::default.not-found";
                            }
                        }
                    }

                    $renderedBlocks[] = view($viewName, [
                        'type' => $blockType,
                        'data' => $block['data'] ?? []
                    ])->render();
                } catch (\Throwable $blockException) {
                    $blockId = $block['id'] ?? "блок #{$index}";
                    $blockType = $block['type'] ?? 'unknown';
                    throw new Exception("Ошибка при обработке блока {$blockId} типа '{$blockType}': {$blockException->getMessage()}");
                }
            }

            return implode($renderedBlocks);
        } catch (EditorJSException $e) {
            throw new Exception("Ошибка валидации EditorJS: {$e->getMessage()}");
        } catch (\Throwable $e) {
            if (strpos($e->getMessage(), 'Ошибка при обработке блока') !== false) {
                throw $e; // Пробрасываем ошибку с информацией о блоке
            }
            throw new Exception("Ошибка при обработке редактора: {$e->getMessage()}");
        }
    }
}
