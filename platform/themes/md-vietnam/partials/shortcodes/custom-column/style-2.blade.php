<section class="box-sumenh">
    <div class="list-item-sumenh">
        <div class="item-sumenh-member">
            <div class="icon-member-sumenh">
                <div class="images-sumenh">
                    @if ($shortcode->image)
                    {{ RvMedia::image($shortcode->image) }}
                    @endif
                </div>
            </div>
            <div class="box-content-sumenh">
                <h2>{{ $shortcode->title ?? '' }}</h2>
                <p>{!! $shortcode->description_editor !!}</p>
            </div>
        </div>
    </div>
</section>
