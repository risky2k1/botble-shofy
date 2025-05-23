<section class="customer">
    <div class="container">
        <div class="box-customer-container">
            <div class="hedding-customer">
                <span>{{ $shortcode->title }}</span>
                @if ($shortcode->description)
                <div class="desc-hedding-custommer">
                    <p>
                        {{ $shortcode->description }}
                    </p>
                </div>
                @endif
            </div>
        </div>

        <div class="box-slider-custumer">
            <div class="swiper-wrapper">
                @foreach($testimonials as $testimonial)
                <div class="single-client-card swiper-slide">
                    <div class="quote">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M464 256h-80v-64c0-35.3 28.7-64 64-64h8c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24h-8c-88.4 0-160 71.6-160 160v240c0 26.5 21.5 48 48 48h128c26.5 0 48-21.5 48-48V304c0-26.5-21.5-48-48-48zm-288 0H96v-64c0-35.3 28.7-64 64-64h8c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24h-8C71.6 32 0 103.6 0 192v240c0 26.5 21.5 48 48 48h128c26.5 0 48-21.5 48-48V304c0-26.5-21.5-48-48-48z" />
                        </svg>
                    </div>
                    <div class="content-text">
                        {!! BaseHelper::clean($testimonial->content) !!}
                    </div>
                    <div class="media">
                        <div class="media-left">
                            {{ RvMedia::image($testimonial->image, $testimonial->name) }}
                        </div>
                        <div class="media-body">
                            <h4>{{ $testimonial->name }}</h4>
                            <span class="text-peaster-member">{{ $testimonial->company }}</span>
                            <span class="tp-review-meta">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        width="20"
                                        height="20" viewBox="0 0 24 24" fill="#fcb040"
                                        class="icon icon-tabler icons-tabler-filled icon-tabler-star">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" />
                                    </svg>
                                    @endfor
                                    <span>5.0</span>
                            </span>
                        </div>
                    </div>
                </div>

                @endforeach

            </div>
        </div>
    </div>
</section>
