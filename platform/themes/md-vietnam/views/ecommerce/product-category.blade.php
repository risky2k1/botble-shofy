@php
    Theme::set('pageTitle', $category->name);
@endphp

@if ($category->page_id && $category->page_id != 0 && $category->page)
    <section>
        {!! $category->page->content !!}
    </section>
@else
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                @if (!$category->content)
                    <p class="mt-4">{{ __('Content not updated yet') }}...</p>
                @endif
                {!! BaseHelper::clean($category->content) !!}
            </div>
        </div>
    </div>

    {{-- <section class="tp-shop-area @if (!theme_option('theme_breadcrumb_enabled', true)) pt-50 @endif">
    <div class="container">
        {!! dynamic_sidebar('products_by_category_top_sidebar') !!}

        @include(Theme::getThemeNamespace('views.ecommerce.includes.products-listing'), ['pageName' => $category->name,
        'pageDescription' => $category->content])

        {!! dynamic_sidebar('products_by_category_bottom_sidebar') !!}
    </div>
</section> --}}
@endif

{{-- @include(Theme::getThemeNamespace('views.ecommerce.includes.related-products')) --}}
