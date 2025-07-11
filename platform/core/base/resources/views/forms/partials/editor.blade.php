@if (!Arr::get($attributes, 'without-buttons', false))
    @php
        $id = Arr::get($attributes, 'id', $name);
        Arr::set($attributes, 'id', $id);
        $page = request()->page ?? collect();
    @endphp

    <div class="mb-2 btn-list">
        <x-core::button type="button" data-result="{{ $id }}" class="show-hide-editor-btn">
            {{ trans('core/base::forms.show_hide_editor') }}
        </x-core::button>

        {{-- ✅ Nút chuyển sang trình chỉnh sửa Page builder --}}

        @if (is_plugin_active('page-builder') && Route::currentRouteName() === 'pages.edit')
            @php

                $route = '/admin/page-builders/builder?id=' . $page->id . '&ref_lang=' . request()->get('ref_lang', null);

            @endphp

            <x-core::button type="button" icon="ti ti-layout" class="page-builder-btn"
                onclick="window.open('{{ $route }}', '_blank')">
                {{ __('plugins/page-builder::page-builder.page_builder') }}
            </x-core::button>

        @endif


        <x-core::button type="button" icon="ti ti-photo" class="btn_gallery" data-result="{{ $id }}"
            data-multiple="true" data-action="media-insert-{{ BaseHelper::getRichEditor() }}">
            {{ trans('core/media::media.add') }}
        </x-core::button>

        {!! apply_filters(BASE_FILTER_FORM_EDITOR_BUTTONS, null, $attributes, $id) !!}
    </div>

    @push('header')
        {!! apply_filters(BASE_FILTER_FORM_EDITOR_BUTTONS_HEADER, null, $attributes, $id) !!}
    @endpush

    @push('footer')
        {!! apply_filters(BASE_FILTER_FORM_EDITOR_BUTTONS_FOOTER, null, $attributes, $id) !!}
    @endpush
@else
    @php Arr::forget($attributes, 'with-short-code'); @endphp
@endif

{!! call_user_func_array([Form::class, BaseHelper::getRichEditor()], [$name, $value, $attributes]) !!}
