<section class="box-sumenh">
    <div class="container">
        <div class="list-item-sumenh">
            @foreach ($tabs as $tab)
                <div class="item-sumenh-member">
                    <div class="icon-member-sumenh">
                        <div class="images-sumenh">
                            @if (isset($tab['image']))
                                {{ RvMedia::image($tab['image']) }}
                            @endif
                        </div>
                    </div>
                    <div class="box-content-sumenh">
                        <h2>{{ $tab['title'] ?? '' }}</h2>
                        <p>{!! BaseHelper::clean(nl2br($tab['description'] ?? '')) !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
