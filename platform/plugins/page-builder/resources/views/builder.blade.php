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

    <link rel="stylesheet" href="{{ asset('vendor/core/plugins/page-builder/css/style.css') }}">
</head>

<body>
    <input type="hidden" id="save-route" value="{{ route('page-builder.save', $page->id) }}">

    <div id="editor">
        {{-- Toolbar --}}
        <div class="editor-toolbar">
            <button id="undo-button" class="btn btn-secondary" title="Undo Last Action (Ctrl+Z)">
                <i class="fas fa-undo"></i> Undo
            </button>
            <button id="duplicate-element" class="btn btn-secondary">
                <i class="fas fa-copy"></i> Duplicate
            </button>
            <button id="link-element" class="btn btn-info">
                <i class="fas fa-link"></i> Add Link
            </button>
            <button id="save-content" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Content
            </button>
            <button id="delete-element" class="btn btn-danger">
                <i class="fas fa-trash"></i> Delete
            </button>
            <button id="add-table" class="btn btn-success" title="Add Table">
                <i class="fas fa-table"></i> Add Table
            </button>
            <button id="add-grid" class="btn btn-info" title="Add Grid Layout">
                <i class="fas fa-th-large"></i> Add Grid
            </button>
            <input type="file" id="image-upload" accept="image/*" style="display: none;">
            <button id="upload-image" class="btn btn-warning" title="Add Image">
                <i class="fas fa-image"></i> Add Image
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

    <script type="module" src="{{ asset('vendor/core/plugins/page-builder/js/main.js') }}"></script>
</body>

</html>
