<section class="condition-2">
    <div class="container">
        <div class="box-body-memeber-condition-2">
            <div class="row">
                <div class="col-lg-6">
                    <div class="desc-content-body-condition-2">
                        <div class="hedding-item-body-condition-2">
                            @if ($shortcode->subtitle_left)
                                <span>{{ $shortcode->subtitle_left }}</span>
                            @endif
                            @if ($shortcode->title_left)
                                <h2>{{ $shortcode->title_left }}</h2>
                            @endif
                        </div>

                        @if ($shortcode->description_left)
                            <div class="content-list-condition-2">
                                {!! $shortcode->description_left !!}
                            </div>
                        @endif
                        @if ($shortcode->image_left)
                            <div>
                                {{ RvMedia::image($shortcode->image_left) }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="desc-content-body-condition-2">
                        <div class="hedding-item-body-condition-2">
                            @if ($shortcode->subtitle_right)
                                <span>{{ $shortcode->subtitle_right }}</span>
                            @endif
                            @if ($shortcode->title_right)
                                <h2>{{ $shortcode->title_right }}</h2>
                            @endif
                        </div>

                        @if ($shortcode->description_right)
                            <div class="content-list-condition-2">
                                {!! $shortcode->description_right !!}
                            </div>
                        @endif
                        @if ($shortcode->image_right)
                            <div>
                                {{ RvMedia::image($shortcode->image_right) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
