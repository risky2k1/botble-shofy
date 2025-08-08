<section class="box-brand-container">
    <div class="container">
        <div class="box-member-brand">
            <div class="row ai-center js-between">
                @if ($shortcode->title_heading)
                <div class="col-lg-4">
                    <div class="box-hedding-title-brand">
                        <h2 class="vc_custom_heading">
                            {{ $shortcode->title_heading }}
                        </h2>
                    </div>
                </div>
                @endif
                <div class="{{ $shortcode->title_heading ? 'col-lg-6' : 'col-lg-12' }}">
                    <div class="vc_column_container-brand">
                        <div class="list-brand-slider" data-loop="{{ $shortcode->is_loop == 'yes' }}"
                            data-autoplay="{{ $shortcode->is_autoplay == 'yes' }}"
                            data-effect="{{ $shortcode->effect }}"
                            data-autoplay-speed="{{ in_array($shortcode->autoplay_speed, [2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000, 10000]) ? $shortcode->autoplay_speed : 5000 }}">

                            {{-- @dd($sliders) --}}
                            <div class="swiper-wrapper">
                                @foreach($sliders as $slider)
                                <div class="item-brand-slider swiper-slide">
                                    <div class="box-images-brand-slider-twe">
                                        @include(Theme::getThemeNamespace('partials.shortcodes.simple-slider.includes.image',
                                        compact('slider')))
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
