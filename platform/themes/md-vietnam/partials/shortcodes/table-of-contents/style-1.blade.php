<section class="REASONS-p1">
    <div class="container">
        <div class="list-reasons-body">
            <div class="box-item-member-reasons">
                <div class="item-header-reasons">
                    @if ($shortcode->subtitle_left)
                        <span style="color: {{ $shortcode->text_color }}">{{ $shortcode->subtitle_left }}</span>
                    @endif

                    <div class="box-right-item-reasons-header">

                        @if ($shortcode->title_right || $shortcode->title_left)
                            <span style="color: {{ $shortcode->text_color }}">{{ $shortcode->title_left ?? $shortcode->title_right }}</span>
                        @endif
                        @if ($shortcode->subtitle_right_2 || $shortcode->subtitle_left_2)
                            <p>{{ $shortcode->subtitle_left_2 ?? $shortcode->subtitle_right_2 }}</p>
                        @endif
                    </div>
                    @if ($shortcode->subtitle_right)
                        <span style="color: {{ $shortcode->text_color }}">{{ $shortcode->subtitle_right }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
