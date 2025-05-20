<section class="box-brand-container">
    <div class="container">
        <div class="box-member-brand">
            <div class="row ai-center">
                <div class="col-lg-12">
                    <div class="box-brand-cl">
                        <div class="row">
                            @if ($shortcode->title_heading)
                            <div class="item-left-brand-cl col-lg-2">
                                <span>
                                    {{ $shortcode->title_heading }}
                                </span>
                            </div>
                            @endif
                            <div class="list-slick-slider-brand-mafei {{ $shortcode->title_heading ? 'col-lg-10' : 'col-lg-12' }}"
                                data-loop="{{ $shortcode->is_loop == 'yes' }}"
                                data-autoplay="{{ $shortcode->is_autoplay == 'yes' }}"
                                data-effect="{{ $shortcode->effect }}"
                                data-autoplay-speed="{{ in_array($shortcode->autoplay_speed, [2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000, 10000]) ? $shortcode->autoplay_speed : 5000 }}">

                                <div class="swiper-wrapper">
                                    @foreach($sliders as $slider)
                                    <div class="item-slider-mafei-brand swiper-slide">
                                        @include(Theme::getThemeNamespace('partials.shortcodes.simple-slider.includes.image',
                                        compact('slider')))
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
