@if ($product->brand->id)
    <div class="tp-product-details-category">
        <span>
            <a href="{{ $product->brand->url }}">{{ $product->brand->name }}</a>
        </span>
    </div>
@endif

<h1 class="tp-product-details-title">{{ $product->name }}</h1>

<div class="tp-product-details-inventory d-flex align-items-center mb-10">
    @if (is_plugin_active('marketplace') && $product->store?->id)
        <div class="tp-product-details-stock mb-10">
            <span><a href="{{ $product->store->url }}">{{ $product->store->name }}</a></span>
        </div>
    @endif

    @if (EcommerceHelper::isReviewEnabled() && ($product->reviews_avg || theme_option('ecommerce_hide_rating_star_when_is_zero', 'no') === 'no'))
        <div class="tp-product-details-rating-wrapper d-flex align-items-center mb-10">
            <div class="tp-product-details-rating">
                <a href="{{ $product->url }}#product-review" data-bb-toggle="scroll-to-review">
                    @include(EcommerceHelper::viewPath('includes.rating-star'), ['avg' => $product->reviews_avg])
                </a>
            </div>
            <div class="tp-product-details-reviews">
                <a href="{{ $product->url }}#product-review" data-bb-toggle="scroll-to-review">{{ __('(:count reviews)', ['count' => number_format($product->reviews_count)]) }}</a>
            </div>
        </div>
    @endif
</div>

{!! apply_filters('ecommerce_before_product_description', null, $product) !!}

{{-- @if ($product->description)
    <div class="tp-product-details-description mb-20">
        {!! BaseHelper::clean($product->description) !!}
    </div>
@endif --}}

{!! apply_filters('ecommerce_after_product_description', null, $product) !!}

{{-- @include(EcommerceHelper::viewPath('includes.product-price'), [
    'priceWrapperClassName' => 'tp-product-details-price-wrapper mb-20',
    'priceClassName' => 'tp-product-details-price new-price',
    'priceOriginalWrapperClassName' => '',
    'priceOriginalClassName' => 'tp-product-details-price old-price',
]) --}}

@if (EcommerceHelper::isTaxEnabled() && get_ecommerce_setting('display_tax_description', false))
    <div class="tp-product-details-tax-text mb-20">
        <small class="text-secondary">
            @php
                $taxes = $product->taxes->isNotEmpty()
                    ? $product->taxes
                    : collect([(object)['title' => get_ecommerce_setting('default_tax_rate') ? Tax::find(get_ecommerce_setting('default_tax_rate'))->title : '', 'percentage' => get_ecommerce_setting('default_tax_rate') ? Tax::find(get_ecommerce_setting('default_tax_rate'))->percentage : 0]]);

                $taxNames = $taxes->map(fn($tax) => $tax->title . ' ' . $tax->percentage . '%')->implode(' + ');
            @endphp

            @if (EcommerceHelper::isDisplayProductIncludingTaxes())
                ({{ __('Including :tax', [
                    'tax' => $taxNames,
                ]) }})
            @else
                ({{ __('Excluding :tax', [
                    'tax' => $taxNames,
                ]) }})
            @endif
        </small>
    </div>
@endif

<x-core::form :url="route('public.cart.add-to-cart')" method="POST" class="product-form">
    <input type="hidden" name="id" value="{{ $product->getIdForCart() }}" />

    @if ($product->variations->isNotEmpty())
        {!! render_product_swatches($product, ['selected' => $selectedAttrs]) !!}
    @endif

    {{-- {!! render_product_options($product) !!} --}}

    {{-- @include(Theme::getThemeNamespace('views.ecommerce.includes.product-availability')) --}}

    @if (isset($flashSale))
        <div class="tp-product-details-countdown justify-content-between flex-wrap mt-25 mb-25">
            <h4 class="tp-product-details-countdown-title">
                <x-core::icon name="ti ti-flame" />
                {{ __('Flash Sale end in:') }}
            </h4>
            <div class="tp-product-details-countdown-time" data-countdown data-date="{{ $flashSale->end_date }}">
                <ul>
                    <li><span data-days>0</span>{{ trim(__(':days D', ['days' => null])) }}</li>
                    <li><span data-hours>0</span>{{ trim(__(':hours H', ['hours' => null])) }}</li>
                    <li><span data-minutes>0</span>{{  trim( __(':minutes M', ['minutes' => null])) }}</li>
                    <li><span data-seconds>0</span>{{ trim(__(':seconds S', ['seconds' => null])) }}</li>
                </ul>
            </div>
        </div>
    @endif

    {!! apply_filters(ECOMMERCE_PRODUCT_DETAIL_EXTRA_HTML, null, $product) !!}
</x-core::form>

{{-- <div class="tp-product-details-query">
    <div class="tp-product-details-query-item " @style(['display: none' => ! $product->sku])>
        <span>{{ __('SKU:') }}</span>
        <span data-bb-value="product-sku">{{ $product->sku }}</span>
    </div>
    @if ($product->categories->isNotEmpty())
        <div class="tp-product-details-query-item">
            <span>{{ __('Category:') }}</span>
            @foreach($product->categories as $category)
                <a href="{{ $category->url }}" title="{{ $category->name }}">{{ $category->name }}</a><span class="me-1">@if (!$loop->last),@endif</span>
            @endforeach
        </div>
    @endif
    @if ($product->tags->isNotEmpty())
        <div class="tp-product-details-query-item">
            <span>{{ __('Tag:') }}</span>
            @foreach($product->tags as $tag)
                <a href="{{ $tag->url }}">{{ $tag->name }}</a><span class="me-1">@if (!$loop->last),@endif</span>
            @endforeach
        </div>
    @endif
</div> --}}
