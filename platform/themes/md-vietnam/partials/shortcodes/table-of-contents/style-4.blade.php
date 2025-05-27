<div class="section-container condition-3">
    <div class="container">
        <div class="section-content">
            <div class="row">
                <div class="col-lg-6">
                    <div class="column-left">
                        @if ($shortcode->subtitle_left)
                            <div class="column-number">{{ $shortcode->subtitle_left }}</div>
                        @endif
                        @if ($shortcode->title_left)
                            <h3 class="column-title">{{ $shortcode->title_left }}</h3>
                        @endif

                        @if ($shortcode->description_left)
                            {!! $shortcode->description_left !!}
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="column-right">
                        @if ($shortcode->subtitle_right)
                            <div class="column-number">{{ $shortcode->subtitle_right }}</div>
                        @endif
                        @if ($shortcode->title_right)
                            <h3 class="column-title">{{ $shortcode->title_right }}</h3>
                        @endif

                        @if ($shortcode->description_right)
                            {!! $shortcode->description_right !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
