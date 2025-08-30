# План доработки рендера EditorJS (laravel-editorjs-parser)

Цель: добавить метод `renderBlocksdata()` с обогащёнными метаданными, упростить логику изображений под CDN responsive и подготовить поддержку галереи, не ломая текущий `renderBlocks()`.

## 1) Новый метод renderBlocksdata()
- Сигнатура: `renderBlocksdata(array $blocks, string|array $template_dir = 'default', array $options = []): array`
- Возвращаемый формат для каждого блока:
  - `['html' => $render, 'type' => $block['type'], 'data' => $block['data'], 'length' => strlen(Str::squish(strip_tags(str_replace("\n", '', $render))))]`
- Поведение:
  - Полностью совместимо с текущими шаблонами блоков.
  - Не трогаем существующий `renderBlocks()` (оставляем как есть), новый метод — альтернативный API.
  - Для блока `image` выбирать шаблон `image-responsive.blade.php` (если доступен), иначе fallback: `image-light.blade.php` → `image.blade.php`.

## 2) Поддержка `$template_dir` как массива
- Параметр может быть строкой или массивом строк, например: `['zen', 'xml']`.
- Фоллбэк разрешения шаблонов: сначала по порядку элементов массива, затем `'default'`.
- Реализовать хелпер: `resolveTemplatePath($template, string|array $template_dir): string`.
  - При поиске шаблона `image-responsive` проходить по цепочке директорий; если не найден — пробовать `image-light`, затем `image`.

## 3) Упрощение логики изображений и responsive
- Цель: убрать сложную файловую логику, перейти на CDN responsive.
- Подход:
  - Для блоков типа `image` использовать уже подготовленные CDN возможности:
    - Если доступен `media->responsive_images['media_library_original']['srcset_cdn']`, брать его для `srcset`.
    - Иначе (на переходном этапе) собрать `srcset` через `ImageService->url($originalUrl, $width)` по фиксированному набору ширин.
  - Шаблон по умолчанию для `renderBlocksdata(image)` — `image-responsive.blade.php` (добавлен в `resources/views/default/`).
  - `sizes` — дефолт/конфигурируемый, например `(max-width: 768px) 100vw, 768px`.
  - Если исходный размер изображения существенно больше целевого — оборачиваем тег `<img>` ссылкой на оригинал `<a href="{original}" data-gallery="1">…</a>` для лайтбокса.
  - Ленивая нагрузка: `loading="lazy"`, `decoding="async"`.

## 4) Ссылка для галереи (подготовка)
- Добавить опциональный `data-gallery`/`rel` в обёртку `<a>`.
- В опциях метода поддержать флаг `with_gallery_link` (по умолчанию true для image).
- При наличии нескольких изображений в контейнерном блоке поддержать единый идентификатор галереи (`data-gallery="{blockId}"`).

## 5) Обработка краевых случаев
- Внешние URL (не наши Media): генерировать `<img src>` напрямую, без `srcset_cdn`.
- Не-изображения в блоке `image` (ошибочные данные): вывести плейсхолдер/ничего, не падать.
- Отсутствие responsive данных: выводить только `src`.

## 6) Производительность и безопасность
- Не выполнять файловых операций и тяжёлых ресайзов; использовать CDN URLs.
- Никаких миграций/refresh DB при тестировании (см. правило проекта).

## 7) Инкрементальная реализация
- Шаг 1: Внедрить `resolveTemplatePath()` и новый метод `renderBlocksdata()` без изменения существующих вызовов.
- Шаг 2: В image-рендере использовать `srcset_cdn` при наличии, иначе fallback через `ImageService`.
- Шаг 3: Добавить обёртку `<a href="original" data-gallery>` при включённой опции.
- Шаг 4: Минимальные smoke-тесты на 2–3 типа блоков + image.

## 8) Точки интеграции
- Файл: `src/LaravelEditorJsParser.php` — добавить метод `renderBlocksdata()` и вспомогательные хелперы разрешения шаблонов.
- Зависимости: `Ixbtcom\Common\Services\ImageService` (через `app()`), `Illuminate\Support\Str`.

## 9) Обратная совместимость
- `renderBlocks()` не меняем.
- Шаблоны совместимы, fallback к `default` сохранён.

## 10) После готовности responsive
- Перейти на использование только `srcset_cdn` из media, исключив fallback через `ImageService`, когда CDN responsive полностью готов.
- Добавить возможность единой галереи для наборов изображений (например, в блоках gallery).
