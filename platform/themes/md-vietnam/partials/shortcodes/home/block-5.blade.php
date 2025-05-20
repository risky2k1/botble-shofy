<section class="equal" style="background: url({{ RvMedia::getImageUrl($data->background_image) }})">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="ModuleContent-equal-left">
                    <a href="javascript:void(0)">
                        {{ RvMedia::image($data->image_left,
                        $data->title, null, true) }}
                    </a>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="box-content-equal-right">
                    <div class="modul-equal-top">
                        <div class="box-container-equal-top">
                            <div class="hedding-equal-top-text-connet">
                                <span>{{ $data->title }}</span>
                            </div>
                            <div class="list-equal-right">
                                <div class="swiper-wrapper">
                                    @foreach ($listEqualRights as $item)
                                    <div class="item-equal-cake swiper-slide">
                                        <a href="javascript:void(0)">
                                            {{ RvMedia::image($item['image'],
                                            $item['title'], null, true, ['width' => 80, 'height' => 80]) }}

                                            <div class="content-equal-item-member">
                                                <span>{{ $item['title'] }}</span>
                                                <p>
                                                    {{ $item['description'] }}
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>

                        <div class="box-suleco-bottom">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="content-suleco-bottom">
                                        <div class="hedding-suleco">
                                            <span>{{ $data->title_bottom_left }}</span>
                                        </div>
                                        <div class="content-vamas-suleco">
                                            <div class="item-vamas-suleco">
                                                <div class="images-vamas-suleco">
                                                    {{ RvMedia::image($data->image_bottom_left_1,
                                                    $data->description_bottom_left_1, null, true, ['width' => 65,
                                                    'height' => 65]) }}
                                                </div>
                                                <div class="content-aspact-vamas">
                                                    <p>{{ $data->description_bottom_left_1 }}</p>
                                                </div>
                                            </div>
                                            <div class="item-vamas-suleco">
                                                <div class="images-vamas-suleco">
                                                    {{ RvMedia::image($data->image_bottom_left_2,
                                                    $data->description_bottom_left_2, null, true, ['width' => 65,
                                                    'height' => 65]) }}
                                                </div>
                                                <div class="content-aspact-vamas">
                                                    <p>{{ $data->description_bottom_left_2 }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="succer-col">
                                        <div class="content-succer-col">
                                            <p>
                                                {{ $data->title_bottom_right }}
                                            </p>
                                        </div>
                                        <div class="star--succer-col">
                                            {{ RvMedia::image($data->image_bottom_right,
                                            $data->title_bottom_right, null, true) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
