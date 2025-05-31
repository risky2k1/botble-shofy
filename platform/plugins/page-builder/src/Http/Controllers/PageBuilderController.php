<?php

namespace Botble\PageBuilder\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\PageBuilder\Http\Requests\PageBuilderRequest;
use Botble\PageBuilder\Models\PageBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Page\Models\Page;
use Botble\PageBuilder\Tables\PageBuilderTable;
use Botble\PageBuilder\Forms\PageBuilderForm;
use Botble\Theme\Facades\Theme;
use Illuminate\Http\Request;

class PageBuilderController extends BaseController
{
    public function builder(Request $request)
    {
        Theme::fireEventGlobalAssets();

        $page = Page::findOrFail($request->id);

        if (! $page) {
            abort(404);
        }

        return view('plugins/page-builder::builder', compact('page'));
    }

    public function saveBuilder(Request $request, $pageId)
    {
        $page = Page::findOrFail($pageId);

        if (! $page) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found.',
            ], 404);
        }

        $page->content = $request->input('content');
        $page->save();

        return response()->json([
            'success' => true,
            'message' => 'Page content saved successfully.',
        ], 200);
    }
}
