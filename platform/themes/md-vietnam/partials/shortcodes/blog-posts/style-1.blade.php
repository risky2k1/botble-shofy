@if ($posts->isNotEmpty())
    <section class="tp-blog-area pb-10">
        <div class="container">
            <section class="tp-related-product">
                <div class="container">
                    <div class="tp-section-title-wrapper-6 text-center mb-40">
                        <h3 class="section-title tp-section-title-6">{{ $shortcode->title ?? '' }}</h3>
                    </div>
                </div>
            </section>

            {{-- <div class="row align-items-center mb-40">
                <div class="col-xl-4 col-md-6">
                    {!! Theme::partial('section-title', compact('shortcode')) !!}
                </div>

            </div> --}}

            <div class="row">
                <div class="col-xl-12">
                    <div class="tp-blog-main-slider overflow-hidden">
                        <div class="tp-blog-main-slider-active-3 row">
                            <div class="swiper-wrapper">
                                @foreach ($posts as $post)
                                    <div class="swiper-slide">
                                        <div class="tp-blog-thumb p-relative fix">
                                            <a href="{{ $post->url }}">
                                                {{ RvMedia::image($post->image, $post->name, 'rectangle') }}
                                            </a>
                                            <div class="tp-blog-meta tp-blog-meta-date">
                                                <span>{{ Theme::formatDate($post->created_at) }}</span>
                                            </div>
                                        </div>
                                        <div class="tp-blog-content">
                                            <h3 class="tp-blog-title text-truncate">
                                                <a href="{{ $post->url }}" title="{{ $post->name }}">
                                                    {!! BaseHelper::clean($post->name) !!}
                                                </a>
                                            </h3>
                                            <p>{{ Str::words($post->description, 20) }}</p>
                                        </div>
                                        <div>
                                            <a href="{{ $post->url }}" title="{{ $post->name }}"
                                                class="btn btn-primary mt-2">
                                                {{ __('Read More') }}
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="my-3">
                            <div class="tp-post-related-swiper-scrollbar tp-swiper-scrollbar"></div>
                        </div>

                        @if ($posts instanceof \Illuminate\Pagination\Paginator || $posts instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            @if ($posts->hasPages())
                                <div class="related-post-pagination mt-3">
                                    {!! $posts->links(Theme::getThemeNamespace('partials.pagination')) !!}
                                </div>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
