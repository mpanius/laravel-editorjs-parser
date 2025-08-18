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
     * @param string $template_dir
     * @param array|null $media
     * @return string
     * @throws Exception
     */
    public function render(string $data,$template_dir = 'default') : string
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

    public function renderBlocks(string $data,$template_dir = 'default', bool $withMedia = false) : array
    {




        $configJson = json_encode(config('laravel-editorjs-parser.config') ?: []);

        $editor = new EditorJS($data, $configJson);

        $renderedBlocks = [];

        $renderedImages = [];

        $renderedMeta = [];




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

            $viewData = [
                'type' => $block['type'],
                'data' => $block['data']
            ];

            if((strtolower($block['type']) === 'image') && (in_array($viewName,["laravel-editorjs-parser::default.image","laravel-editorjs-parser::zen.image"]))){

                if($viewName === "laravel-editorjs-parser::default.image")
                {
                    $viewName = "laravel-editorjs-parser::default.image-light";
                }

                $dimensions = $this->calculateImageDimensions($block['data'], $viewName);


                if ($dimensions) {
                    $renderedImages[] = $dimensions;
                    // Добавляем dimensions прямо в data для использования в шаблоне
                    $viewData['data']['dimensions'] = $dimensions;
                }
            }

            $renderedBlock = view($viewName, $viewData)->render();
            $renderedMeta = ['type' => $block['type'], 'length' => Str::squish(strip_tags(str_replace('\n','', $renderedBlock)))];
            $renderedBlocks[] = $renderedBlock;
        }

        return $withMedia ? ['blocks' => $renderedBlocks, 'images' => $renderedImages, 'meta' => $renderedMeta] : $renderedBlocks;

    }

    /**
     * Calculate image dimensions for responsive display
     *
     * @param array $data Block data containing media information
     * @param string $viewName View name to determine template-specific sizing
     * @return array|null Calculated dimensions or null if media not found
     */
    private function calculateImageDimensions(array $data, string $viewName = ''): ?array
    {
        $mediaId = $data['file']['media_id'] ?? $data['media_id'] ?? null;
        $media = media($mediaId);

        if (empty($media)) {
            return null;
        }

        $imageUrl = $media->getFullUrl() ?? null;
        if (empty($imageUrl)) {
            return null;
        }

        $originalWidth = $media->width ?? $media->getCustomProperty('width') ?? 0;
        $originalHeight = $media->height ?? $media->getCustomProperty('height') ?? 0;

        // Определяем, является ли изображение маленьким (меньше 400px по ширине)
        $isSmallImage = $originalWidth > 0 && $originalWidth < 400;

        // Максимальная ширина контейнера публикации
        // Для zen используем 1600, для остальных 920
        $maxWidth = ($viewName === "laravel-editorjs-parser::zen.image") ? 1600 : 920;
        // Максимальная высота изображения на десктопе
        // Для zen используем 1200, для остальных 700
        $maxDesktopHeight = ($viewName === "laravel-editorjs-parser::zen.image") ? 1200 : 700;

        // Определяем оптимальные размеры для разных устройств
        $desktopWidth = (($originalWidth > 0) && ($originalWidth < $maxWidth)) ? $originalWidth : $maxWidth;
        $tabletWidth = min(736, $desktopWidth);
        $mobileWidth = min(480, $desktopWidth);

        // Вычисляем соотношение сторон
        $aspectRatio = (($originalWidth > 0) && ($originalHeight > 0)) ? $originalWidth / $originalHeight : 0;

        // Рассчитываем ФИНАЛЬНЫЕ размеры десктопной картинки
        $finalWidth = $desktopWidth;
        $finalHeight = $maxDesktopHeight;

        if (($originalWidth > 0) && ($originalHeight > 0) && ($aspectRatio > 0)) {
            $scaleW = $desktopWidth / $originalWidth;
            $scaleH = $maxDesktopHeight / $originalHeight;
            $scale = min($scaleW, $scaleH);
            $finalWidth = round($originalWidth * $scale);
            $finalHeight = round($originalHeight * $scale);
        }

        return [
            'originalWidth' => $originalWidth,
            'originalHeight' => $originalHeight,
            'finalWidth' => $finalWidth,
            'finalHeight' => $finalHeight,
            'desktopWidth' => $desktopWidth,
            'tabletWidth' => $tabletWidth,
            'mobileWidth' => $mobileWidth,
            'maxDesktopHeight' => $maxDesktopHeight,
            'isSmallImage' => $isSmallImage,
            'aspectRatio' => $aspectRatio,
            'imageUrl' => img($imageUrl, $desktopWidth, $maxDesktopHeight),
            'fullImageUrl' => $imageUrl
        ];
    }
}
