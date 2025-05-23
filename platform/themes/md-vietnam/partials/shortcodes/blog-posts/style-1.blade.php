<section class="tp-blog-area pt-50 pb-10">
    <div class="container">
        <div class="row align-items-center mb-40">
            <div class="col-xl-4 col-md-6">
                {!! Theme::partial('section-title', compact('shortcode')) !!}
            </div>
            
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="tp-blog-main-slider">
                    <div class="tp-blog-main-slider-active row">
                        @foreach($posts as $post)
                            <div class="tp-blog-item mb-30 col-lg-3 col-6 ">
                                
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
                            </div>
                        @endforeach
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
