{{-- <div class="col-xl-4 col-lg-3 col-md-4 col-sm-6"> --}}
<div class="panel panel-default">
    <div class="tp-footer-widget footer-col-1 mb-50">
        <div class="tp-footer-widget-content">
            <div class="tp-footer-logo">
                @if ($logo = $config['logo'])
                    <a href="{{ BaseHelper::getHomepageUrl() }}">
                        {{ RvMedia::image($logo, Theme::getSiteTitle(), attributes: $attributes) }}
                    </a>
                @endif
            </div>
            <div class="tp-footer-desc">
                {!! BaseHelper::clean(nl2br($config['about'])) !!}
            </div>
            @if (isset($config['title']))
            <div class="mb-4">
                <span class="tp-footer-title">{{ $config['title'] }}</span>
            </div>
            @endif
            @if (count($tabs) > 0)
                <div class="list-footer-left-nav mt-4">
                    <ul class="elementor-icon-list-items">
                        @foreach ($tabs as $tab)
                            <li class="elementor-icon-list-item">
                                @if (isset($tab['icon']) && ($icon = $tab['icon']) && BaseHelper::hasIcon($icon))
                                    <span>
                                        {!! BaseHelper::renderIcon($icon) !!}
                                    </span>
                                @endif
                                <span class="elementor-icon-list-text">{{ $tab['title'] }}:
                                    {!! $tab['description'] !!}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($config['show_social_links'] && ($socialLinks = Theme::getSocialLinks()))
                <div class="tp-footer-social mt-4">
                    @foreach ($socialLinks as $socialLink)
                        @continue(!$socialLink->getUrl() || !$socialLink->getIconHtml())

                        <a {!! $socialLink->getAttributes() !!}>{{ $socialLink->getIconHtml() }}</a>
                    @endforeach
                </div>
            @endif

            @if (isset($config['image']) && $image = $config['image'])
                <div class="tp-footer-image mt-15">
                    <a href="{{ BaseHelper::getHomepageUrl() }}">
                        {{ RvMedia::image($image, Theme::getSiteTitle(), attributes: $attributes) }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
