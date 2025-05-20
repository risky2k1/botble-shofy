<x-core::layouts.base>
    @include('core/base::layouts.' . AdminAppearance::getCurrentLayout() . '.partials.before-content')

    <div @class([
        'page-wrapper',
        'rv-media-integrate-wrapper' => Route::currentRouteName() === 'media.index',
    ])>
        @include('core/base::layouts.partials.page-header')

        {{-- Modal edit file --}}
        <div class="modal fade modal-image" id="modal-edit-file" style="z-index: 99999;">
            <div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <a class="close" href="javascript:void(0);" style="
                            position: absolute;
                            width: 13px;
                            height: 32px;
                            top: -7px;
                            right: 15px;
                            opacity: 0.8;
                            transition: all 200ms;
                            font-size: 32px;
                            text-decoration: none;
                            color: #222;
                            z-index: 99999;
                            cursor: pointer;
                            ">&times;</a>
                        <div id="image-editor-wrapper">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End modal edit file --}}

        <div class="page-body page-content">
            <div class="{{ AdminAppearance::getContainerWidth() }}">
                {!! apply_filters('core_layout_before_content', null) !!}

                @yield('content')

                {!! apply_filters('core_layout_after_content', null) !!}
            </div>
        </div>

        @include('core/base::layouts.partials.footer')
    </div>

    @include('core/base::layouts.' . AdminAppearance::getCurrentLayout() . '.partials.after-content')

    <x-slot:header-layout>
        @if (\Botble\Base\Supports\Core::make()->isSkippedLicenseReminder())
            @include('core/base::system.license-invalid', ['hidden' => false])
        @endif
    </x-slot:header-layout>

    <x-slot:footer>
        @include('core/base::global-search.form')
        @include('core/media::partials.media')

        {!! rescue(fn () => app(Tighten\Ziggy\BladeRouteGenerator::class)->generate(), report: false) !!}

        @if(App::hasDebugModeEnabled())
            <x-core::debug-badge />
        @endif
    </x-slot:footer>
</x-core::layouts.base>
