<section class="box-brand-container">
    <div class="container">
        <div class="box-member-brand">
            <div class="row ai-center">
                <div class="col-lg-6">
                    <div class="box-hedding-title-brand">
                        <h2 class="vc_custom_heading">
                            {{ $data->title }}
                        </h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="vc_column_container-brand">
                        <div class="list-brand-slider">
                            <div class="swiper-wrapper">
                                @foreach ($memberBrands as $memberBrand)
                                <div class="item-brand-slider swiper-slide">
                                    <div class="box-images-brand-slider-twe">
                                        {{ RvMedia::image($memberBrand['image_1'],
                                        $memberBrand['alt'], null, true) }}
                                    </div>
                                    <div class="box-images-brand-slider-twe">
                                        {{ RvMedia::image($memberBrand['image_2'],
                                        $memberBrand['alt'], null, true) }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
