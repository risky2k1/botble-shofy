@php
    $category_ids = explode(',', $shortcode->category_ids);

    $posts = get_posts_by_category($category_ids, 10, 0, true);
@endphp
<section class="field">
    <div class="ctnr">
        <div class="box-field-container">
            <div class="row">
                <div class="lvhd_col_left col-md-5 col-sm-12">
                    <div class="box-wrapper-field-left">
                        <h2 class="lvhd_title">{{ $shortcode->title }}</h2>
                        <div class="lvhd_des">
                            {{ $shortcode->description }}
                        </div>
                        @if ($shortcode->action_label && $shortcode->action_url)
                            <div class="lvhd_xem_them">
                                <a class="btt_white"
                                    href="{{ $shortcode->action_url }}">{{ $shortcode->action_label }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="lvhd_col_right col-md-7 col-sm-12">
                    <div class="box-lvhd-right">
                        <div class="swiper-wrapper">
                            @foreach ($categories as $category)
                                <div class="swiper-slide">
                                    <div class="slide_item_wrapper"
                                        style=" background-image: url('{{ RvMedia::getImageUrl($category->image) }}');">
                                        <div class="slide_item_inner">
                                            <div class="lvhd_slide_title">
                                                {{ $category->name }}
                                            </div>
                                            <div class="lvhd_slide_des">
                                                {{ strip_tags($category->description) }}
                                            </div>
                                            <div class="lvhd_slide_xem_them">
                                                <a href="{{ $category->url }}"
                                                    class="btt_white">{{ __('Read more') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="lvhd-button-next swiper-button-disabled"></div>
                    <div class="lvhd-button-prev"></div>
                </div>
            </div>
        </div>
    </div>
    </div>

    @if (count($categories) > 0)
        <div class="lvhd_col_bottom col-md-12 col-sm-12">
            <div class="tabs nganh-hang-tabs tabs-simple tabs-light ctnr">
                <div class="box-nav-tabs-hangngang">
                    <ul class="nav nav-tabs nav-justified featured-boxes">
                        @foreach ($categories as $key => $category)
                            <li class="nav-item {{ $key === 0 ? 'active' : '' }}"
                                data-electronic="bvc{{ $key }}">
                                <a class="nav-link">
                                    {{-- <span class="featured-box featured-box-light">
                                        <span class="box-content"><i class="icon-featured icon-image">
                                                {{ RvMedia::image($category->image, $category->name, 'rectangle') }}</i>
                                        </span>
                                    </span> --}}
                                    <span class="tab-title">{{ $category->name }}</span></a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-content">
                    @foreach ($categories as $key => $category)
                        <div class="tab-pane {{ $key === 0 ? 'active' : '' }}" id="bvc{{ $key }}">
                            <div class="porfolio-cat-list home_sp_kkgd_wrapper">
                                <div class="swiper-wrapper">
                                    @foreach ($category->posts as $post)
                                        <div class="swiper-slide">
                                            <div class="portfolio-item-wrapper">
                                                <a href="{{ $post->url }}">
                                                    <div class="pitem-image">
                                                        {{ RvMedia::image($post->image, $post->name) }}
                                                    </div>
                                                    <div class="pitem-title">
                                                        {{ $post->name }}
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="lvhd-button-prev swiper-button-disabled"></div>
                                <div class="lvhd-button-next"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    </div>
    </div>
    </div>
</section>
