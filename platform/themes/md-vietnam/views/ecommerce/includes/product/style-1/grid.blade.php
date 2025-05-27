<div @class(['tp-product-item transition-3 mb-25', 'tp-product-item-3 tp-product-style-primary mb-50' => $style === 3, $class ?? null])>
    <div class="tp-product-thumb p-relative fix m-img">
        <a href="{{ $product->url }}">
            {{ RvMedia::image($product->image, $product->name, 'rectangle') }}
        </a>

        {{-- @include(Theme::getThemeNamespace('views.ecommerce.includes.product.badges')) --}}

        {{-- @include(Theme::getThemeNamespace('views.ecommerce.includes.product.style-1.actions')) --}}
    </div>

    <div class="tp-product-content">
        {!! apply_filters('ecommerce_before_product_item_content_renderer', null, $product) !!}

        @if (is_plugin_active('marketplace') && $product->store?->id)
            <div class="tp-product-category">
                <a href="{{ $product->store->url }}">{{ $product->store->name }}</a>
            </div>
        @endif
        <h3 class="text-truncate tp-product-title">
            <a href="{{ $product->url }}" title="{{ $product->name }}">
                {{ $product->name }}
            </a>
        </h3>
        <div class="tp-product-desc">
            {!! $product->description !!}
        </div>
        <div>
            <a href="{{ $product->url }}" title="{{ $product->name }}" class="btn btn-primary mt-2">
                {{ __('Read More') }}
            </a>
        </div>

        {!! apply_filters('ecommerce_after_product_item_content_renderer', null, $product) !!}
    </div>
</div>
