<section class="block-news">
    <div class="container">
        <div class="box-block-news">
            <div class="section-heading">
                <h2 class="heading-2">{{ $shortcode->title }}</h2>
                @if(($buttonLabel = $shortcode->button_label) && ($buttonUrl = $shortcode->button_url ?:
                get_blog_page_url()))
                <a class="btn btn-primary" href="{{ $buttonUrl }}">
                    <span>
                        {!! BaseHelper::clean($buttonLabel) !!}
                    </span>
                    <em class="far fa-arrow-right-to-arc"></em>
                </a>
                @endif
            </div>

            @php
            $postFirst = $posts->first();
            @endphp
            
            <div class="row">
                <div class="col-lg-6">

                    <div class="news-item news-item-big">
                        <div class="news-item-img">
                            <figure>
                                <a href="{{ $postFirst->url }}" title="{{ $postFirst->name }}">
                                    {{ RvMedia::image($postFirst->image, $postFirst->name, null, true) }}
                                </a>
                            </figure>
                        </div>
                        <div class="news-item-caption">
                            <div class="news-item-date">
                                <span>{{ Theme::formatDate($postFirst->created_at) }}</span>
                            </div>
                            <div class="news-item-title">
                                <a title="{{ $postFirst->name }}" href="{{ $postFirst->url }}">
                                     {!! BaseHelper::clean($postFirst->name) !!}
                                </a>
                            </div>
                            <div class="news-item-brief">
                                {!! Str::words($postFirst->description, 20) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="news-slide-list">
                        <div class="swiper-wrapper">
                            @foreach($posts as $post)
                            @if($post->id == $postFirst->id)
                            @continue
                            @endif
                            <div class="news-item news-item-side swiper-slide">
                                <div class="news-item-img">
                                    <figure>
                                        <a href="{{ $post->url }}" title="{{ $post->name }}">
                                            {{ RvMedia::image($post->image, $post->name, null, true) }}
                                        </a>
                                    </figure>
                                </div>
                                <div class="news-item-caption">
                                    <div class="news-item-date">
                                        <span>{{ Theme::formatDate($post->created_at) }}</span>
                                    </div>
                                    <div class="news-item-title">
                                        <a href="{{ $post->url }}" title="{{ $post->name }}">
                                            {!! BaseHelper::clean($post->name) !!}
                                        </a>
                                    </div>
                                    <div class="news-item-brief">
                                        {!! Str::words($post->description, 20) !!}
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
