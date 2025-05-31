<div class="box-list-scholarships">
    <section class="scholarships">
        <div class="container">
            <div class="list-scholarships">
                <div class="scholarships-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="hedding-scholarships">
                                @if ($shortcode->subtitle_left)
                                    <span
                                        style="color: {{ $shortcode->text_color }}">{{ $shortcode->subtitle_left }}</span>
                                @endif
                                @if ($shortcode->title_left)
                                    <p style="color: {{ $shortcode->text_color }}">
                                        {{ $shortcode->title_left ?? $shortcode->title_right }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="hedding-scholarships">
                                @if ($shortcode->subtitle_right)
                                    <span
                                        style="color: {{ $shortcode->text_color }}">{{ $shortcode->subtitle_right }}</span>
                                @endif
                                @if ($shortcode->title_right)
                                    <p style="color: {{ $shortcode->text_color }}">
                                        {{ $shortcode->title_left ?? $shortcode->title_right }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @if ($shortcode->image_left)
                            <div class="col-lg-6">
                                {{ RvMedia::image($shortcode->image_left) }}
                            </div>
                        @endif
                        @if ($shortcode->description_right && $shortcode->description_right != '</undefined>')
                            <div class="col-lg-6">
                                <div class="desc-scholarships">
                                    {!! $shortcode->description_right !!}
                                </div>
                            </div>
                        @endif
                        @if ($shortcode->description_left && $shortcode->description_left != '</undefined>')
                            <div class="col-lg-6">
                                <div class="desc-scholarships">
                                    {!! $shortcode->description_left !!}
                                </div>
                            </div>
                        @endif
                        @if ($shortcode->image_right)
                            <div class="col-lg-6">
                                {{ RvMedia::image($shortcode->image_right) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
