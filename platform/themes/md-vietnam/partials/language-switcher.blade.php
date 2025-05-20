@if (is_plugin_active('language'))
    @php
        $type ??= 'desktop';

        $supportedLocales = Language::getSupportedLocales();
        $languageDisplay = setting('language_display', 'all');
    @endphp

    @if ($supportedLocales && count($supportedLocales) > 1)
        @if ($type === 'desktop')
            <div class="language-selector">
                <select onchange="if(this.value) window.location.href=this.value;">
                    @foreach ($supportedLocales as $localeCode => $properties)
                        <option value="{{ Language::getSwitcherUrl($localeCode, $properties['lang_code']) }}"
                            @if ($localeCode === Language::getCurrentLocale()) selected @endif>
                            {{ $properties['lang_name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        @else
            <div class="offcanvas__select language">
                <div class="offcanvas__lang d-flex align-items-center justify-content-md-end">
                    <div class="offcanvas__lang-img mr-15">
                        @if ($languageDisplay === 'all' || $languageDisplay === 'flag')
                            {!! language_flag(Language::getCurrentLocaleFlag(), Language::getCurrentLocaleName(), 24) !!}
                        @endif
                    </div>
                    <div class="offcanvas__lang-wrapper">
                        <span class="offcanvas__lang-selected-lang tp-lang-toggle" id="tp-offcanvas-lang-toggle">
                            @if ($languageDisplay === 'all' || $languageDisplay === 'name')
                                {{ Language::getCurrentLocaleName() }}
                            @endif
                        </span>
                        <ul class="offcanvas__lang-list tp-lang-list">
                            @foreach ($supportedLocales as $localeCode => $properties)
                                @continue($localeCode === Language::getCurrentLocale())
                                <li>
                                    <a href="{{ Language::getSwitcherUrl($localeCode, $properties['lang_code']) }}"
                                        class="d-flex align-items-center gap-2">
                                        @if ($languageDisplay === 'all' || $languageDisplay === 'flag')
                                            {!! language_flag($properties['lang_flag'], $properties['lang_name']) !!}
                                        @endif
                                        @if ($languageDisplay === 'all' || $languageDisplay === 'name')
                                            <span class="text-nowrap">{{ $properties['lang_name'] }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endif
