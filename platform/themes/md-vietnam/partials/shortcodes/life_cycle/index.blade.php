<section class="develop" style="background: {{ $shortcode->image ?  }}">
    <div class="ctnr">
        <h2 class="title-section title-section__big ta-center">
            {{ $shortcode->title }}
        </h2>
        <div class="milestone-content p-relative">
            @foreach ($tabs as $tab)
                <div class="timeline-item">
                    <div class="timeline-year">
                        <span
                            @if (isset($tab['color'])) style="background-color: {{ $tab['color'] }};" @endif>{{ $tab['title'] ?? '' }}</span>
                    </div>
                    <div class="timeline-event">
                        <p>{!! BaseHelper::clean(nl2br($tab['description'] ?? '')) !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
