@php
    Theme::set('breadcrumbStyle', 'without-title');
    Theme::layout('full-width');
    Theme::asset()->container('footer')->usePath()->add('waypoints', 'plugins/waypoints/jquery.waypoints.min.js');

    $flashSale = $product->latestFlashSales()->first();

    Theme::set('pageTitle', $product->name);
@endphp

<section class="tp-product-details-area @if (! theme_option('theme_breadcrumb_enabled', true)) pt-50 @endif">
    {!! apply_filters('ads_render', null, 'detail_page_before') !!}

    <div class="tp-product-details-top bb-product-detail">
        <div class="container">
            <div class="row">

                <div class="col-lg-12">
                    <div class="tp-product-details-wrapper has-sticky">
                        @include(Theme::getThemeNamespace('views.ecommerce.includes.product-detail'))

                        {!! dynamic_sidebar('product_details_sidebar') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @if (EcommerceHelper::isEnabledCrossSaleProducts())
        @include(Theme::getThemeNamespace('views.ecommerce.includes.cross-sale-products'))
    @endif --}}

    <div class="tp-product-details-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    {!! BaseHelper::clean($product->content) !!}
                </div>
            </div>
        </div>
    </div>

    {!! apply_filters('ads_render', null, 'detail_page_after') !!}
</section>

@if (EcommerceHelper::isEnabledRelatedProducts())
    @include(Theme::getThemeNamespace('views.ecommerce.includes.related-products'))
@endif
