@php
    $style = in_array($shortcode->style, [1, 2, 3, 4, 5, 6, 7]) ? $shortcode->style : 1;
@endphp

{!! Theme::partial("shortcodes.multiple-custom-columns.style-$style", compact('shortcode', 'tabs')) !!}
