<section class="box-brand-container">
    <div class="container">
        <div class="box-member-brand">
            <div class="row ai-center">
                <div class="col-lg-12">
                    <div class="box-brand-cl">
                        <div class="row">
                            <div class="item-left-brand-cl col-lg-2">
                                <span> Đối tác chiến lược </span>
                            </div>
                            <div class="list-slick-slider-brand-mafei col-lg-10">
                                <div class="swiper-wrapper">
                                    @foreach ($memberBrands as $memberBrand)
                                    <div class="item-slider-mafei-brand swiper-slide">
                                        {{ RvMedia::image($memberBrand['image'],
                                        $memberBrand['alt'], null, true) }}
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
