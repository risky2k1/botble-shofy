{!! SeoHelper::render() !!}

@if ($favicon = theme_option('favicon'))
    {{ Html::favicon(
        RvMedia::getImageUrl($favicon),
        ['type' => rescue(fn () => File::mimeType(RvMedia::getRealPath($favicon)), 'image/x-icon')]
    ) }}
@endif

@if (Theme::has('headerMeta'))
    {!! Theme::get('headerMeta') !!}
@endif

{!! apply_filters('theme_front_meta', null) !!}

@php
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => rescue(function () {
            return SeoHelper::openGraph()->getProperty('site_name');
        }),
        'url' => url(''),
    ];
@endphp

<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>

{!! Theme::typography()->renderCssVariables() !!}

{!! Theme::asset()->container('before_header')->styles() !!}
{!! Theme::asset()->styles() !!}
{!! Theme::asset()->container('after_header')->styles() !!}
{!! Theme::asset()->container('header')->scripts() !!}

{!! apply_filters(THEME_FRONT_HEADER, null) !!}

<script>
    window.siteUrl = "{{ rescue(fn() => BaseHelper::getHomepageUrl()) }}";
</script>
