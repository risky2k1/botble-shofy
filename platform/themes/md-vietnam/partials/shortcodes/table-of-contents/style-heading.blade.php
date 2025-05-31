<section class="REASONS-p1 tp-full-width">
    <div class="hedding-reasons" style="background-color: {{ $shortcode->background_color }} !important;">
        <div class="container">
            <div class="hedding-member-reasons">
                @if ($shortcode->subtitle_left)
                    <span>{{ $shortcode->subtitle_left }}</span>
                @endif
                @if ($shortcode->title_left)
                    <h2 style="color: {{ $shortcode->text_color }} !important;">{{ $shortcode->title_left }}</h2>
                @endif
                @if ($shortcode->subtitle_left_2)
                    <p style="color: {{ $shortcode->text_color }} !important;">{{ $shortcode->subtitle_left_2 }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
