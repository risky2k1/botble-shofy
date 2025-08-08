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
            <div class="slick-wrapper-single-client-card">
                @foreach ($testimonials as $testimonial)
                    <div class="single-client-card ">
                        <div class="quote">
                            <svg fill="#ffffff" width="64px" height="64px" viewBox="0 0 32 32" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <title>quote</title>
                                    <path
                                        d="M9.563 8.469l-0.813-1.25c-5.625 3.781-8.75 8.375-8.75 12.156 0 3.656 2.688 5.375 4.969 5.375 2.875 0 4.906-2.438 4.906-5 0-2.156-1.375-4-3.219-4.688-0.531-0.188-1.031-0.344-1.031-1.25 0-1.156 0.844-2.875 3.938-5.344zM21.969 8.469l-0.813-1.25c-5.563 3.781-8.75 8.375-8.75 12.156 0 3.656 2.75 5.375 5.031 5.375 2.906 0 4.969-2.438 4.969-5 0-2.156-1.406-4-3.313-4.688-0.531-0.188-1-0.344-1-1.25 0-1.156 0.875-2.875 3.875-5.344z">
                                    </path>
                                </g>
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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="#fcb040"
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
