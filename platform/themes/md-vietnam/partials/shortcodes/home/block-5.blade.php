<section class="equal" style="background: url({{ RvMedia::getImageUrl($data->background_image) }})">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="ModuleContent-equal-left">
                    <a href="{{ $data->link_left }}" target="_blank">
                        {{ RvMedia::image($data->image_left, $data->title, null, true) }}
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
                                @foreach ($listEqualRights as $item)
                                    <div class="item-equal-cake">
                                        <a href="{{ $item['link'] }}" target="_blank">
                                            {{ RvMedia::image($item['image'], $item['title'], null, true, ['width' => 80, 'height' => 80]) }}

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
                </div>
            </div>
        </div>
    </div>
</section>
