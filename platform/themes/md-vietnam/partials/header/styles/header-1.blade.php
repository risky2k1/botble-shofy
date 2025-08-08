<div class="box-member-form">
    <div class="popup-overlay" id="popupOverlay">
        <div class="popup-container">
            <div class="popup-header">
                <button class="close-btn">×</button>
                <h2> {{ __('FREE CONSULTATION') }}</h2>
            </div>

            <div class="popup-content" id="popupForm">
                <form id="contactForm" action="{{ route('public.send.contact.fast') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" id="name" name="name" class="form-control"
                            placeholder="{{ __('Fullname') }}" required>
                    </div>

                    <div class="form-group">
                        <input type="tel" id="phone" name="phone" class="form-control"
                            placeholder="{{ __('Phone number') }}" required>
                    </div>

                    <div class="form-group">
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="{{ __('Email') }}" required>
                    </div>

                    <div class="form-group">
                        <textarea id="content" name="content" class="form-control" required
                            placeholder="{{ __('Hello, I need help with') }}..."></textarea>
                    </div>


                    <div class="ta-center">
                        <button type="submit" class="submit-btn">{{ __('CONSULT NOW') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<header>
    <div class="container header-container">
        <div class="logo">
            {!! Theme::partial('header.logo') !!}
        </div>
        {!! Menu::renderMenuLocation('main-menu', ['view' => 'main-menu']) !!}

        <div class="d-flex align-items-center justify-content-end gap-2 header-right language-mobile">
            <div> {!! Theme::partial('language-switcher', ['type' => 'mobile']) !!}</div>
            <div class="mobile-menu-btn">
                <x-core::icon name="ti ti-menu-2" size="sx" />
            </div>
        </div>
        <div class="contact-info">
            <a href="tel:{{ theme_option('hotline') }}" class="hotline">
                {{ __('Call now') }}
                {{--
                <x-core::icon name="ti ti-brand-telegram" size="sx" /> --}}
            </a>
            {!! Theme::partial('language-switcher', ['type' => 'desktop']) !!}
        </div>
    </div>
    <div id="button-contact-vr">
        <div id="gom-all-in-one">
            @foreach (Theme::getSocialLinks() as $socialLink)
                @if ($socialLink->getDisplayType() !== 'footer')
                    <div id="{{ $socialLink->getName() ?? '' }}-vr" class="button-contact">
                        <div class="phone-vr">
                            <div class="phone-vr-circle-fill"
                                style="background-color: {{ $socialLink->getBackgroundColor() ?? '' }}"></div>
                            <div class="phone-vr-img-circle"
                                style="background-color: {{ $socialLink->getBackgroundColor() ?? '' }}">
                                <a href="{{ $socialLink->getUrl() ?? '' }}" target="_blank"
                                    rel="nofollow noopener noreferrer">
                                    @if ($socialLink->getImage())
                                        <img src="{{ RvMedia::getImageUrl($socialLink->getImage()) }}"
                                            alt="{{ $socialLink->getName() }}">
                                    @else
                                        <x-core::icon name="{{ $socialLink->getIcon() }}" size="lg"
                                            style="color: {{ $socialLink->getColor() ?? '' }};" />
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

        </div>
    </div>
</header>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const popupOverlay = document.getElementById('popupOverlay');
        const openButtons = document.querySelectorAll('.btn-dangky-form');
        const closeButtons = popupOverlay.querySelectorAll('.close-btn, .trigger-btn');

        function openPopup() {
            popupOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closePopup() {
            popupOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        openButtons.forEach(btn => {
            btn.addEventListener('click', openPopup);
        });

        closeButtons.forEach(btn => {
            btn.addEventListener('click', closePopup);
        });

        popupOverlay.addEventListener('click', function(e) {
            if (e.target === popupOverlay) {
                closePopup();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && popupOverlay.classList.contains('active')) {
                closePopup();
            }
        });
    });
</script>
