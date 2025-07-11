@php
    $layout = request()->query('layout', theme_option('blog_posts_layout', 'grid'));
    $layout = in_array($layout, ['grid', 'list']) ? $layout : 'grid';
    Theme::layout('full-width');

    $blogSidebar = dynamic_sidebar('blog_sidebar');
@endphp


<section @class([
    'tp-blog-grid-area pb-20',
    'pt-50' => !theme_option('theme_breadcrumb_enabled', true),
])>
    {!! apply_filters('ads_render', null, 'listing_page_before') !!}
    <div class="container">
        <div class="row pb-10">
            @if ($posts->isNotEmpty())
                <div class="col-lg-6">
                    @php
                        $firstPost = $posts->first();
                    @endphp
                    @if ($firstPost)
                        <div class="news-item news-item-big">
                            <div class="news-item-img">
                                <figure>
                                    <a href="{{ $firstPost->url }}">
                                        {{ RvMedia::image($firstPost->image, $firstPost->name) }}
                                    </a>
                                </figure>
                            </div>
                            <div class="news-item-caption">
                                <div class="news-item-date">{{ Theme::formatDate($firstPost->created_at) }}</div>
                                <div class="news-item-title">
                                    <a href="{{ $firstPost->url }}">{{ $firstPost->name }}</a>
                                </div>
                                <div class="news-item-brief">
                                    {{ $firstPost->description }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-lg-6">
                    <div class="news-slide-list swiper-initialized swiper-vertical swiper-backface-hidden">
                        <div class="swiper-wrapper">
                            @foreach ($posts->slice(1, 4) as $post)
                                <div class="news-item news-item-side swiper-slide"
                                    style="height: 155px; margin-bottom: 20px;">
                                    <div class="news-item-img">
                                        <figure>
                                            <a href="{{ $post->url }}">
                                                {{ RvMedia::image($post->image, $post->name) }}
                                            </a>
                                        </figure>
                                    </div>
                                    <div class="news-item-caption">
                                        <div class="news-item-date">{{ Theme::formatDate($post->created_at) }}</div>
                                        <div class="news-item-title">
                                            <a href="{{ $post->url }}">{{ $post->name }}</a>
                                        </div>
                                        <div class="news-item-brief">
                                            {{ $post->description }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                    </div>
                </div>
            @else
                <div class="text-center tp-error-content">
                    <p>{{ __("Looks like we don't have any posts matching your search.") }}</p>
                    <a href="{{ get_blog_page_url() }}" class="tp-error-btn">{{ __('Back to Blog') }}</a>
                </div>
            @endif
        </div>
        <div class="row pb-10">
            @foreach ($posts->slice(5) as $post)
                <div class="col-lg-4">
                    <div class="box-block-list-bottom">
                        <div class="news-item news-item-side ">
                            <div class="news-item-img">
                                <figure>
                                    <a href="{{ $post->url }}">
                                        {{ RvMedia::image($post->image, $post->name) }}
                                    </a>
                                </figure>
                            </div>
                            <div class="news-item-caption">
                                <div class="news-item-date">{{ Theme::formatDate($post->created_at) }}</div>
                                <div class="news-item-title">
                                    <a href="{{ $post->url }}">{{ $post->name }}</a>
                                </div>
                                <div class="news-item-brief">
                                    {{ $post->description }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="tp-blog-pagination mt-10">
                    {{ $posts->links(Theme::getThemeNamespace('partials.pagination')) }}
                </div>
            </div>
        </div>
    </div>
</section>
