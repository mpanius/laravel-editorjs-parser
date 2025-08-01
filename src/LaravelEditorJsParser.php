<?php

namespace Ixbtcom\LaravelEditorJsParser;

use EditorJS\EditorJS;
use Exception;
use Illuminate\Support\Facades\Cache;
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
    public function render(string $data,$template_dir = 'default', ?array $media = null) : string
    {




            $configJson = json_encode(config('laravel-editorjs-parser.config') ?: []);

            $editor = new EditorJS($data, $configJson);

            $renderedBlocks = [];




            foreach ($editor->getBlocks() as $block) {

                $viewName = "laravel-editorjs-parser::{$template_dir}." . Str::snake($block['type'], '-');

                if (! View::exists($viewName)) {
                    if($template_dir === 'default')
                    {
                        $viewName = "laravel-editorjs-parser::default.not-found";
                    } else
                    {
                        $viewName = "laravel-editorjs-parser::default." . Str::snake($block['type'], '-');
                        if(!View::exists($viewName)){
                            $viewName = "laravel-editorjs-parser::default.not-found";
                        }
                    }
                }

                $renderedBlocks[] = view($viewName, [
                    'type' => $block['type'],
                    'data' => $block['data']
                ])->render();
            }

            return implode($renderedBlocks);

    }

    public function renderBlocks(string $data,$template_dir = 'default', ?array $media = null) : array
    {




        $configJson = json_encode(config('laravel-editorjs-parser.config') ?: []);

        $editor = new EditorJS($data, $configJson);

        $renderedBlocks = [];




        foreach ($editor->getBlocks() as $block) {

            $viewName = "laravel-editorjs-parser::{$template_dir}." . Str::snake($block['type'], '-');

            if (! View::exists($viewName)) {
                if($template_dir === 'default')
                {
                    $viewName = "laravel-editorjs-parser::default.not-found";
                } else
                {
                    $viewName = "laravel-editorjs-parser::default." . Str::snake($block['type'], '-');
                    if(!View::exists($viewName)){
                        $viewName = "laravel-editorjs-parser::default.not-found";
                    }
                }
            }

            $renderedBlocks[] = view($viewName, [
                'type' => $block['type'],
                'data' => $block['data']
            ])->render();
        }

        return $renderedBlocks;

    }
}
