<div class="ss03_abouts">
    <div class="ctnr">
        <div class="row">
            @foreach ($tabs as $tab)
                <div class="clm" style="--w-lg: 4; --w-xs: 12;">
                    <div class="images_tamnhin_sumenh">
                        @if (isset($tab['image']))
                            {{ RvMedia::image($tab['image']) }}
                        @endif
                        <h2>{{ $tab['title'] ?? '' }}</h2>
                        <p>{{ $tab['subtitle'] ?? '' }}</p>
                        <div class="desc_vpdd">
                            <p>{!! BaseHelper::clean(nl2br($tab['description'] ?? '')) !!}</p>
                        </div>
                        @if (isset($tab['action_label']) && $tab['action_url'])
                            <a href="{{ $tab['action_url'] }}">{{ $tab['action_label'] }}</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
