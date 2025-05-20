<header>
    <div class="container header-container">
        <div class="logo">
            {!! Theme::partial('header.logo') !!}
        </div>
        {!! Menu::renderMenuLocation('main-menu', ['view' => 'main-menu']) !!}

        <div class="mobile-menu-btn">
            <x-core::icon name="ti ti-menu-2" size="sx" />
        </div>
        <div class="contact-info">
            <a href="tel:{{ theme_option('hotline') }}" class="hotline">
                {{ __('Call now') }}
                <x-core::icon name="ti ti-brand-telegram" size="sx" />
            </a>
            {!! Theme::partial('language-switcher', ['type' => 'desktop']) !!}
        </div>
    </div>
</header>
