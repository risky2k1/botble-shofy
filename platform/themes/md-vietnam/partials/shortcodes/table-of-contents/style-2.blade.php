<section class="condition tp-full-width" style="background: {{ $shortcode->background_color }}">
    <div class="container">
        <div class="box-condition">
            <div class="box-condition-body">
                <div class="condition-body-about">
                    <div class="list-clause">
                        <div class="item-clause">
                            @if ($shortcode->title_left)
                                <div class="clause-item-header">
                                    <span>{{ $shortcode->title_left }}</span>
                                </div>
                            @endif
                            @if ($shortcode->description_left)
                                <div class="content-clause-body-item">
                                    {!! $shortcode->description_left !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
