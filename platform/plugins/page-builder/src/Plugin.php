<?php

namespace Botble\PageBuilder;

use Illuminate\Support\Facades\Schema;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('page_builders');
        Schema::dropIfExists('page_builders_translations');
    }
}
