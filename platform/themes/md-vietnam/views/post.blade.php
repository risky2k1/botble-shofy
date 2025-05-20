@php
Theme::layout('full-width');
Theme::set('breadcrumbStyle', 'without-title');

$relatedPosts = get_related_posts($post->getKey(), 5);
$lastPosts = get_latest_posts(5);
Theme::set('pageTitle', $post->name);

$blogSidebar = dynamic_sidebar('blog_sidebar');

@endphp

<section @class(['tp-postbox-details-area', 'pb-120'=> $relatedPosts->isEmpty(), 'pt-50' => !
    theme_option('theme_breadcrumb_enabled', true)])>
    {!! apply_filters('ads_render', null, 'detail_page_before') !!}

    <div class="container">
        <div class="row">
            <div @class(['col-xl-9 col-lg-8'=> $blogSidebar, 'col-12' => ! $blogSidebar])>
                <div class="tp-postbox-details-top">
                    <h1 class="heading-title-post-details">{{ $post->name }}</h1>
                    <div class="tp-postbox-details-meta mb-50">
                        <span>
                            {{ Theme::formatDate($post->created_at) }}
                        </span>
                        <span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $post->url }}" target="_blank">
                                <img src="{{ Theme::asset()->url('images/icons/fb.png') }}" alt="">
                            </a>
                        </span>
                    </div>
                </div>
                <div class="tp-postbox-details-main-wrapper">
                    <div class="tp-postbox-details-content">
                        <div class="ck-content">{!! BaseHelper::clean($post->content) !!}</div>

                        <div class="tp-postbox-details-share-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    @if ($post->tags->isNotEmpty())
                                    <div class="tp-postbox-details-tags tagcloud">
                                        <span>{{ __('Tags:') }}</span>
                                        @foreach ($post->tags as $tag)
                                        <a href="{{ $tag->url }}">{{ $tag->name }}</a>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, null, $post) !!}
                    </div>
                </div>
            </div>
            @if ($blogSidebar)
            <div class="col-xl-3 col-lg-4">
                <div class="box-slibar-col">
                    <div class="item-slibar-col-member">
                        <div class="title-slibar">
                            <h2>{{ __('Latest News') }}</h2>
                        </div>
                        <div class="body-new-orther">
                            @foreach ($lastPosts as $post)
                            <div class="item-block-sliber-orther">
                                <div class="news-item-img">
                                    <a href="{{ $post->url }}">
                                        {{-- <img src="{{ RvMedia::getImageUrl($post->image, 'thumb') }}"
                                            alt="{{ $post->name }}"> --}}
                                        {{ RvMedia::image($post->image, $post->name, 'rectangle', useDefaultImage: true)
                                        }}
                                    </a>
                                </div>
                                <div class="news-item-caption-block">
                                    <div class="news-item-date ">{{ Theme::formatDate($post->created_at) }}</div>
                                    <div class="news-item-title ">
                                        <a href="{{ $post->url }}">{{ $post->name }}</a>
                                    </div>
                                </div>

                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @if ($relatedPosts->isNotEmpty())
                    <div class="box-slibar-col">
                        <div class="item-slibar-col-member">
                            <div class="title-slibar">
                                <h2>{{ __('Related News') }}</h2>
                            </div>
                            <div class="body-new-orther">
                                @foreach ($relatedPosts as $post)
                                <div class="item-block-sliber-orther">
                                    <div class="news-item-caption-block">
                                        <div class="news-item-date ">{{ Theme::formatDate($post->created_at) }}</div>
                                        <div class="news-item-title ">
                                            <a href="{{ $post->url }}">{{ $post->name }}</a>
                                        </div>
                                    </div>

                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            @endif
        </div>
    </div>

    {{-- @if ($relatedPosts->isNotEmpty())
    <div class="tp-postbox-related-area pt-115 pb-50 mt-50" style="background-color: #F4F7F9">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="tp-postbox-related">
                        <h3 class="tp-postbox-related-title">{{ __('Related Articles') }}</h3>

                        <div class="row">
                            @foreach ($relatedPosts as $relatedPost)
                            <div class="col-md-6 col-lg-4">
                                @include(Theme::getThemeNamespace('views.partials.post-grid-item'), ['post' =>
                                $relatedPost, 'class' => 'tp-blog-grid-style2'])
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif --}}

    {!! apply_filters('ads_render', null, 'detail_page_after') !!}
</section>