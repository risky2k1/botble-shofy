@php
$style = $shortcode->style ?? 1;
@endphp

{!! Theme::partial("shortcodes.table-of-contents.style-$style", compact('shortcode','tabs')) !!}
