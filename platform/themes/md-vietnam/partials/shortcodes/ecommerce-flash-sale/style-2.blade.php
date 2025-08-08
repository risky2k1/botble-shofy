@php
    $title = $shortcode->title;
    $subtitle = $shortcode->subtitle;
@endphp

<section
    class="tp-deal-area pt-50 pb-35 p-relative z-index-1 fix scene"
    style="
        @if ($shortcode->background_color) background-color: {{ $shortcode->background_color }}; @endif
        @if ($shortcode->background_image)
            background-image: url({{ RvMedia::getImageUrl($shortcode->background_image) }}); background-size: cover;
        @endif
    "
>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7">
                <div class="tp-deal-content text-center">
                    @if($title || $subtitle)
                        @if($subtitle)
                            <span class="tp-deal-title-pre">
                                {!! BaseHelper::clean($subtitle) !!}
                                {!! Theme::partial('section-title-shape') !!}
                            </span>
                        @endif
                        @if($title)
                            <h3 class="tp-deal-title">
                                {!! BaseHelper::clean($title) !!}
                            </h3>
                        @endif
                    @endif

                    <div class="tp-deal-countdown">
                        @include(Theme::getThemeNamespace('views.ecommerce.includes.product.countdown'), ['endDate' => $flashSale->end_date])
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
