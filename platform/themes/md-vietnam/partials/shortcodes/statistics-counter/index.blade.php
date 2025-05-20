@php
$style = in_array($data->style, [1, 2, 3, 4, 5, 6, 7]) ? $data->style : 1;
@endphp

{!! Theme::partial("shortcodes.statistics-counter.style-$style", compact('data', 'tabCounterBoxs')) !!}
