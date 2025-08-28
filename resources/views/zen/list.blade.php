@php
    $style = data_get($data, 'style');
    $items = data_get($data, 'items', []);
    $renderItems = function($items, $ordered) use (&$renderItems) {
        if ($ordered) {
            echo '<ol>';
        } else {
            echo '<ul>';
        }
        foreach ($items as $item) {
            $content = is_string($item) ? $item : data_get($item, 'content');
            $nested = is_array($item) ? data_get($item, 'items', []) : [];
            echo '<li>' . $content;
            if (!empty($nested)) {
                $renderItems($nested, $ordered);
            }
            echo '</li>';
        }
        echo $ordered ? '</ol>' : '</ul>';
    };
@endphp
@if($style === 'unordered' || $style === 'checklist')
    @php($renderItems($items, false))
@else
    @php($renderItems($items, true))
@endif
