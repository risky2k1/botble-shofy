{!! apply_filters('ads_render', null, 'footer_before') !!}

@php
    $style = theme_option('footer_style', 1);
    $style = in_array($style, [1, 2, 3, 4, 5]) ? $style : 1;
@endphp

{!! Theme::partial('footer.style-' . $style) !!}

{!! apply_filters('ads_render', null, 'footer_after') !!}
