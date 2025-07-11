<section class="box-sumenh sumenhsimple2">
    <div class="container">
        <div class="list-item-sumenh ">
            <div class="tp-slider-active-8 swiper-container  @if ($shortcode->animation_enabled == 'no') tp-slider-no-animation @endif"
                data-loop="{{ $shortcode->is_loop == 'yes' }}" data-autoplay="{{ $shortcode->is_autoplay == 'yes' }}"
                data-effect="{{ $shortcode->effect }}"
                data-autoplay-speed="{{ in_array($shortcode->autoplay_speed, [2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000, 10000]) ? $shortcode->autoplay_speed : 5000 }}">
                <div class="swiper-wrapper">
                    @foreach ($sliders as $slider)
                        @php
                            $title = $slider->title;
                            $description = $slider->description;
                        @endphp

                        @foreach ($sliders as $slider)
                            <div class="item-slider-mafei-brand swiper-slide">
                                <div class="item-sumenh-member"
                                    style="background-color: {{ $slider->getMetaData('background_color', true) }} !important;">
                                    <div class="icon-member-sumenh">
                                        <div class="images-sumenh">
                                            @if ($slider->image)
                                                {{ RvMedia::image($slider->image) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="box-content-sumenh">
                                        <h2 style="color: {{ $slider->getMetaData('text_color', true) }} !important;  ">
                                            @if (!empty($slider->getMetaData('text_color', true)))
                                                <style>
                                                    .box-content-sumenh h2:before {
                                                        background: {{ $slider->getMetaData('text_color', true) }};
                                                    }
                                                </style>
                                            @endif
                                            {{ $slider->title ?? '' }}
                                        </h2>
                                        <p style="color: {{ $slider->getMetaData('text_color', true) }} !important;">
                                            {!! nl2br($slider->description ?? '') !!}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
