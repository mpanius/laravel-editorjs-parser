<?php

namespace Ixbtcom\LaravelEditorJsParser;

use EditorJS\EditorJS;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Ixbtcom\Common\Services\ImageService;
use Ixbtcom\Common\Models\Media as CommonMedia;

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
            $renderedMeta[] = ['type' => $block['type'], 'length' => strlen(Str::squish(strip_tags(str_replace('\n','', $renderedBlock))))];
            $renderedBlocks[] = $renderedBlock;
        }

        return $withMedia ? ['blocks' => $renderedBlocks, 'images' => $renderedImages, 'meta' => $renderedMeta] : $renderedBlocks;
    }

    /**
     * Resolve Blade view path with support for array of template_dir and fallbacks
     */
    private function resolveTemplatePath(string $template, string|array $template_dir = 'default'): string
    {
        $dirs = is_array($template_dir) ? $template_dir : [$template_dir];
        // always try provided dirs in order, then default
        foreach ($dirs as $dir) {
            $name = "laravel-editorjs-parser::{$dir}.{$template}";
            if (View::exists($name)) {
                return $name;
            }
        }
        $fallback = "laravel-editorjs-parser::default.{$template}";
        return View::exists($fallback) ? $fallback : 'laravel-editorjs-parser::default.not-found';
    }

    /**
     * New API: render blocks array to enriched array with html/type/data/length
     * Does not modify existing render()/renderBlocks() behavior
     *
     * @param array $blocks Editor.js blocks (array form)
     * @param string|array $template_dir single dir or ordered list of dirs
     * @param array $options extra options (e.g., ['with_gallery_link' => true])
     * @return array<int,array{html:string,type:string,data:array,length:int}>
     * @throws Exception
     */
    public function renderBlocksdata(array $blocks, string|array $template_dir = 'default', array $options = []): array
    {
        $out = [];
        $withGallery = $options['with_gallery_link'] ?? true;

        foreach ($blocks as $block) {
            $type = strtolower($block['type'] ?? '');
            $data = (array) ($block['data'] ?? []);

            // Template resolution with image fallbacks
            if ($type === 'image') {
                $viewName = $this->resolveTemplatePath('image-responsive', $template_dir);
                if ($viewName === 'laravel-editorjs-parser::default.not-found') {
                    $viewName = $this->resolveTemplatePath('image-light', $template_dir);
                    if ($viewName === 'laravel-editorjs-parser::default.not-found') {
                        $viewName = $this->resolveTemplatePath('image', $template_dir);
                    }
                }

                // enrich image data with src/srcset/sizes/original
                $this->enrichImageData($data, $template_dir, $withGallery);
            } else {
                $viewName = $this->resolveTemplatePath(Str::snake($type, '-'), $template_dir);
            }

            $html = view($viewName, [
                'type' => $type,
                'data' => $data,
            ])->render();

            $len = strlen(Str::squish(strip_tags(str_replace("\n", '', $html))));
            $out[] = [
                'html' => $html,
                'type' => $type,
                'data' => $data,
                'length' => $len,
            ];
        }

        return $out;
    }

    /**
     * Enrich image block data with responsive information and gallery wrapping hints
     */
    private function enrichImageData(array &$data, string|array $template_dir, bool $withGallery): void
    {
        $mediaId = $data['file']['media_id'] ?? $data['media_id'] ?? null;
        $media = function_exists('media') ? media($mediaId) : null;

        $data['responsive'] = [
            'src' => null,
            'srcset' => null,
            'sizes' => $data['sizes'] ?? '(max-width: 768px) 100vw, 768px',
            'original' => null,
            'link_wrapped' => false,
        ];

        if ($media instanceof CommonMedia) {
            $original = $media->getFullUrl();
            $data['responsive']['original'] = $original;
            $data['responsive']['src'] = $media->getUrl();
            $data['responsive']['srcset'] = $media->getSrcset() ?: null;

            if (!$data['responsive']['srcset']) {
                // Fallback: build srcset from config widths using ImageService
                /** @var ImageService $imageService */
                $imageService = app(ImageService::class);
                $project = config('common.project') ?? config('common.app.slug');
                $allRoot = (array) config('common.images.sizes.by_project.all', []);
                $projectRoot = (array) config("common.images.sizes.by_project.$project", []);
                $profiles = (array) (\Illuminate\Support\Arr::get($projectRoot, 'content_images.responsive')
                    ?? \Illuminate\Support\Arr::get($allRoot, 'content_images.responsive', []));
                $pairs = [];
                foreach ($profiles as $p) {
                    $w = $p['width'] ?? null; $h = $p['height'] ?? null; $mode = $p['mode'] ?? 'resize';
                    if (!$w) { continue; }
                    $u = $imageService->url($original, $w, $h, $mode);
                    if ($u) { $pairs[(string)(int)$w] = $u.' '.((int)$w).'w'; }
                }
                ksort($pairs, SORT_NUMERIC);
                $data['responsive']['srcset'] = $pairs ? implode(', ', array_values($pairs)) : null;
            }

            if ($withGallery && !empty($data['responsive']['original'])) {
                $data['responsive']['link_wrapped'] = true;
            }
        } else {
            // External image or no media helper — leave as-is, ensure src is present
            $url = $data['file']['url'] ?? $data['url'] ?? null;
            if ($url) {
                $data['responsive']['src'] = $url;
                $data['responsive']['original'] = $url;
            }
        }
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
