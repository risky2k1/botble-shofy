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
                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464 256h-80v-64c0-35.3 28.7-64 64-64h8c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24h-8c-88.4 0-160 71.6-160 160v240c0 26.5 21.5 48 48 48h128c26.5 0 48-21.5 48-48V304c0-26.5-21.5-48-48-48zm-288 0H96v-64c0-35.3 28.7-64 64-64h8c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24h-8C71.6 32 0 103.6 0 192v240c0 26.5 21.5 48 48 48h128c26.5 0 48-21.5 48-48V304c0-26.5-21.5-48-48-48z"/></svg>
                    </div>
                    <p class="content-text">
                        {!! BaseHelper::clean($testimonial->content) !!}.
                    </p>
                    <div class="media">
                        <div class="media-left">
                            {{ RvMedia::image($testimonial->image, $testimonial->name) }}
                        </div>
                        <div class="media-body">
                            <h4>{{ $testimonial->name }}</h4>
                            <span>{{ $testimonial->company }}</span>
                            <span class="tp-review-meta">
                                <i class="ic-yellow fa fa-star"></i>
                                <i class="ic-yellow fa fa-star"></i>
                                <i class="ic-yellow fa fa-star"></i>
                                <i class="ic-yellow fa fa-star"></i>
                                <i class="ic-yellow fa fa-star"></i>
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
