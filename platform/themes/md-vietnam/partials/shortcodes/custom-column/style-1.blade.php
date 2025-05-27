<div class="ss03_abouts">
    <div class="ctnr">
        <div class="row">
            <div class="clm">
                <div class="images_tamnhin_sumenh">
                    @if ($shortcode->image)
                        {{ RvMedia::image($shortcode->image) }}
                    @endif
                    <h2>{{ $shortcode->title ?? '' }}</h2>
                    <p>{{ $shortcode->subtitle ?? '' }}</p>
                    <div class="desc_vpdd">
                        <p>{!! $shortcode->description_editor !!}</p>
                    </div>
                    @if ($shortcode->action_label && $shortcode->action_url)
                        <a href="{{ $shortcode->action_url }}">{{ $shortcode->action_label }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
