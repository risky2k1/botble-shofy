<div class="box-slider-custumer-giayphep container"
    @if ($shortcode->animation_enabled == 'no') tp-slider-no-animation @endif"
    data-loop="{{ $shortcode->is_loop == 'yes' }}" data-autoplay="{{ $shortcode->is_autoplay == 'yes' }}"
    data-effect="{{ $shortcode->effect }}"
    data-autoplay-speed="{{ in_array($shortcode->autoplay_speed, [2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000, 10000]) ? $shortcode->autoplay_speed : 5000 }}">

    <div class="swiper-wrapper">
        @foreach ($sliders as $slider)
        <div class="single-client-cards swiper-slide">
            <div class="item-images-slider-products">
                @if ($slider->image)
                    {{ RvMedia::image($slider->image) }}
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
