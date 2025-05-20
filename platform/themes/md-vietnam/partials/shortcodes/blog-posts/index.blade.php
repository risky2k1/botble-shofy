@php
    $style = in_array($shortcode->style, [1, 2, 3, 4, 5]) ? $shortcode->style : 1;
@endphp

{!! Theme::partial("shortcodes.blog-posts.style-$style", compact('shortcode', 'posts')) !!}
