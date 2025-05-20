<div class="footer-bottom-section-twe">
    <div class="row">
        @if (count($tabs) > 0)
            @foreach ($tabs as $tab)
                <div class="col-lg-{{ 12 / count($tabs) }}">
                    <div class="box-item-footer-seciton-twe">
                        <div class="icon-map-section-footer">
                            @if (isset($tab['icon']) && ($icon = $tab['icon']) && BaseHelper::hasIcon($icon))
                                <span>
                                    {!! BaseHelper::renderIcon($icon) !!}
                                </span>
                            @endif
                        </div>
                        <div class="content-section-map-footer">
                            <a href="{{ $tab['url'] }}">
                                {!! BaseHelper::clean($tab['description']) !!}
                                <p>{!! BaseHelper::clean($tab['label']) !!}</p>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
