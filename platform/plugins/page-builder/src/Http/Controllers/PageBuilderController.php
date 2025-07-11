<?php

namespace Botble\PageBuilder\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\PageBuilder\Http\Requests\PageBuilderRequest;
use Botble\PageBuilder\Models\PageBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\LanguageAdvanced\Http\Controllers\LanguageAdvancedController;
use Botble\LanguageAdvanced\Http\Requests\LanguageAdvancedRequest;
use Botble\Page\Forms\PageForm;
use Botble\Page\Models\Page;
use Botble\Page\Repositories\Interfaces\PageInterface;
use Botble\PageBuilder\Tables\PageBuilderTable;
use Botble\PageBuilder\Forms\PageBuilderForm;
use Botble\Theme\Facades\Theme;
use Illuminate\Http\Request;

class PageBuilderController extends BaseController
{
    /**
     * @var PageInterface
     */
    protected $pageRepository;
    /**
     * @var LanguageAdvancedController
     */
    protected $languageAdvancedController;

    /**
     * PageBuilderController constructor.
     * @param PageInterface $pageRepository
     */
    public function __construct(PageInterface $pageRepository, LanguageAdvancedController $languageAdvancedController)
    {
        $this->pageRepository = $pageRepository;
        $this->languageAdvancedController = $languageAdvancedController;
    }


    public function builder(Request $request)
    {

        $page = $this->pageRepository->findOrFail($request->id);

        Theme::fireEventGlobalAssets();

        if (! $page) {
            abort(404);
        }

        $pageForm = PageForm::createFromModel($page)->renderForm();

        return view('plugins/page-builder::builder', compact('page', 'pageForm'));
    }

    public function saveBuilder(Request $request, $pageId)
    {
        if (empty($request->ref_lang)) {
            $page = $this->pageRepository->findOrFail($pageId);

            PageForm::createFromModel($page)
                ->setRequest($request)
                ->save();
        } else {
            $this->languageAdvancedController->save($pageId, new LanguageAdvancedRequest($request->all()));
        }

        return response()->json([
            'success' => true,
            'message' => 'Page content saved successfully.',
        ], 200);
    }
}
