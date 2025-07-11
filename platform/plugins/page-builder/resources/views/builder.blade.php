<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>{{ __('plugins/page-builder::page-builder.visual_editor') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! Theme::typography()->renderCssVariables() !!}

    {!! Theme::asset()->container('before_header')->styles() !!}
    {!! Theme::asset()->styles() !!}
    {!! Theme::asset()->container('after_header')->styles() !!}
    {!! Theme::asset()->container('header')->scripts() !!}


    <style>
        :root {
            --primary-font: "Inter";
            --primary-color: #206bc4;
            --primary-color-rgb: 32, 107, 196;
            --secondary-color: #6c7a91;
            --secondary-color-rgb: 108, 122, 145;
            --heading-color: inherit;
            --text-color: #182433;
            --text-color-rgb: 24, 36, 51;
            --link-color: #206bc4;
            --link-color-rgb: 32, 107, 196;
            --link-hover-color: #1a569d;
            --link-hover-color-rgb: 26, 86, 157;
        }
    </style>
    <link media="all" type="text/css" rel="stylesheet"
        href="https://md.bivaco.net/vendor/core/core/base/css/core.css?v=1.3.5">

    <link rel="stylesheet" href="{{ asset('vendor/core/plugins/page-builder/css/style.css') }}">
</head>

<body>
    <input type="hidden" id="save-route" value="{{ route('page-builder.save', $page->id) }}">
    <input type="hidden" id="page_form" value="{{ json_encode($pageForm) }}">
    <input type="hidden" id="ref_lang" value="{{ request()->get('ref_lang', null) }}">

    <div id="editor">
        {{-- Toolbar --}}
        <div class="editor-toolbar">
            <button id="undo-button" class="btn btn-secondary">
                <x-core::icon name="ti ti-arrow-back-up" />
                <div class="tooltip">Hoàn tác (Ctrl+Z)</div>
            </button>

            <div class="separator"></div>

            <button id="duplicate-element" class="btn btn-secondary">
                <x-core::icon name="ti ti-copy" />
                <div class="tooltip">Nhân bản</div>
            </button>

            <button id="link-element" class="btn btn-info">
                <x-core::icon name="ti ti-link" />
                <div class="tooltip">Thêm liên kết</div>
            </button>

            <div class="separator"></div>

            <button id="save-content" class="btn btn-primary">
                <x-core::icon name="ti ti-device-floppy" />
                <div class="tooltip">Lưu nội dung</div>
            </button>

            <button id="delete-element" class="btn btn-danger">
                <x-core::icon name="ti ti-trash" />
                <div class="tooltip">Xóa</div>
            </button>

            <div class="separator"></div>

            <button id="add-table" class="btn btn-success">
                <x-core::icon name="ti ti-table" />
                <div class="tooltip">Thêm bảng</div>
            </button>

            <button id="add-grid" class="btn btn-info">
                <x-core::icon name="ti ti-layout-grid" />
                <div class="tooltip">Thêm lưới</div>
            </button>

            <button id="add-embed" class="btn btn-danger">
                <x-core::icon name="ti ti-code" />
                <div class="tooltip">Chèn Embed</div>
            </button>

            <button id="upload-image" class="btn btn-warning" href="#">
                <x-core::icon name="ti ti-photo" />
                <div class="tooltip">Thêm hình ảnh</div>
            </button>
        </div>
        {{-- End Toolbar --}}

        {{-- Content --}}
        <div id="content">
            {!! $page->content !!}
        </div>
        {{-- End Content --}}

    </div>

    <div id="sidebar">
        <div id="sidebar-header">
            <h3>🎛️ Control Panel</h3>
        </div>
        <div id="tweakpane-container"></div>
    </div>


    {!! Theme::asset()->container('footer')->styles() !!}
    {!! Theme::asset()->container('footer')->scripts() !!}
    {!! Theme::asset()->container('after_footer')->scripts() !!}

    <script type="text/javascript">
        var BotbleVariables = BotbleVariables || {};
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js"
        integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous">
    </script>
    <script src="{{ asset('vendor/core/core/base/js/app.js?v=' . time()) }}"></script>
    <script src="{{ asset('vendor/core/core/base/js/core-ui.js?v=' . time()) }}"></script>
    <script src="{{ asset('vendor/core/core/base/js/core.js?v=' . time()) }}"></script>
    </script>

    <script type="module" src="{{ asset('vendor/core/plugins/page-builder/js/main.js') }}"></script>


    {{-- MEDIA --}}
    <div style="display: none;">
        @props([
            'name',
            'value',
            'defaultImage' => RvMedia::getDefaultImage(),
            'allowAddFromUrl' => ($isInAdmin = is_in_admin(true) && auth()->guard()->check()),
        ])

        @php
            $value = BaseHelper::stringify($value ?? '');
            $name = '';
            $allowThumb = $attributes->get('allow_thumb', $attributes->get('allow-thumb', true));

            $defaultImage = $attributes->get('preview_image') ?: RvMedia::getDefaultImage();
        @endphp

        <div {{ $attributes->merge(['class' => "image-box image-box-$name"]) }}>
            <input class="image-data" name="{{ $name }}" type="hidden" value="{{ $value }}"
                {{ $attributes->except('action') }} />

            @if (!$isInAdmin)
                @php
                    $name = str_replace(['[', ']'], ['___', ''], $name);
                @endphp

                <input class="media-image-input" type="file" style="display: none;"
                    @if ($name) name="{{ $name }}_input" @endif
                    @if (!isset($attributes['action']) || $attributes['action'] == 'select-image') accept="image/*" @endif {{ $attributes->except('action') }} />
            @endif

            <div style="width: 8rem" @class([
                'preview-image-wrapper mb-1',
                'preview-image-wrapper-not-allow-thumb' => !$allowThumb,
            ])>
                <div class="preview-image-inner">
                    <a data-bb-toggle="image-picker-choose"
                        @if ($isInAdmin) data-target="popup" @else
                        data-target="direct" @endif
                        class="image-box-actions" data-result="{{ $name }}"
                        data-action="{{ $attributes['action'] ?? 'select-image' }}"
                        data-allow-thumb="{{ $allowThumb == true }}" href="#">
                        <x-core::image @class(['preview-image', 'default-image' => !$value])
                            data-default="{{ $defaultImage = $defaultImage ?: RvMedia::getDefaultImage() }}"
                            src="{{ RvMedia::getImageUrl($value, $allowThumb ? 'thumb' : null, false, $defaultImage) }}"
                            alt="{{ trans('core/base::base.preview_image') }}" />
                        <span class="image-picker-backdrop"></span>
                    </a>
                    <x-core::button @style(['display: none' => empty($value), '--bb-btn-font-size: 0.5rem']) class="image-picker-remove-button p-0" :pill="true"
                        data-bb-toggle="image-picker-remove" size="sm" icon="ti ti-x" :icon-only="true"
                        :tooltip="trans('core/base::forms.remove_image')" />
                </div>
            </div>

            <a data-bb-toggle="image-picker-choose"
                @if ($isInAdmin) data-target="popup" @else data-target="direct" @endif
                data-result="{{ $name }}" data-action="{{ $attributes['action'] ?? 'select-image' }}"
                data-allow-thumb="{{ $allowThumb == true }}" href="#">
                {{ trans('core/base::forms.choose_image') }}
            </a>

            @if ($allowAddFromUrl)
                <div data-bb-toggle="upload-from-url">
                    <span class="text-muted">{{ trans('core/media::media.or') }}</span>
                    <a href="javascript:void(0)" class="mt-1" data-bs-toggle="modal"
                        data-bs-target="#image-picker-add-from-url" data-bb-target=".image-box-{{ $name }}">
                        {{ trans('core/media::media.add_from_url') }}
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="media-modal">
        <div class="modal modal-blur fade media-modal rv-media-modal" id="rv_media_modal" tabindex="-1"
            role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-full" role="document">
                <div class="modal-content bb-loading">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ trans('core/media::media.gallery') }}</h5>
                        <x-core::modal.close-button />
                    </div>
                    <div class="p-0 modal-body media-modal-body media-modal-loading" id="rv_media_body">
                        <x-core::loading />
                    </div>
                </div>
            </div>
        </div>

        <x-core::modal id="image-picker-add-from-url" :title="trans('core/media::media.add_from_url')" :form-action="route('media.download_url')" :form-attrs="['id' => 'image-picker-add-from-url-form']">
            <input type="hidden" name="image-box-target">

            <x-core::form.text-input :label="trans('core/media::media.url')" type="url" name="url" placeholder="https://"
                :required="true" />

            <x-core::form.checkbox :label="trans('core/media::media.download_image_to_local_storage')" name="download_image_to_local_storage" value="1"
                id="download_image_to_local_storage" :checked="true">
                <x-slot:helper-text>
                    {{ trans('core/media::media.download_image_to_local_storage_helper') }}
                </x-slot:helper-text>
            </x-core::form.checkbox>

            <x-slot:footer>
                <x-core::button type="button" data-bs-dismiss="modal">
                    {{ trans('core/base::forms.cancel') }}
                </x-core::button>

                <x-core::button type="submit" color="primary" data-bb-toggle="image-picker-add-from-url"
                    form="image-picker-add-from-url-form">
                    {{ trans('core/base::forms.save_and_continue') }}
                </x-core::button>
            </x-slot:footer>
        </x-core::modal>
    </div>

    @include('core/media::config')

    <script src="{{ asset('vendor/core/core/media/js/integrate.js?v=' . time()) }}"></script>

    {!! apply_filters('core_base_media_after_assets', null) !!}

    {{-- END MEDIA --}}
</body>

</html>
