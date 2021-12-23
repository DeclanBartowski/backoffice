<?php

namespace App\Http\Controllers;

use App\Http\Requests\PagesRequest;
use App\Models\Documents;
use App\Models\Pages;
use App\Services\BlocksService;
use App\Services\PagesService;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Documents $document, PagesService $pagesService)
    {
        if($document->user_id != Auth::id())
            abort('404');
        if($request->has('sort_field') && $request->has('sort_order')) {
            $pagesService->setSortParams($request->get('sort_field'), $request->get('sort_order'));
        }
        SEOMeta::setTitle(sprintf('Список страниц “%s”', $document->name));
        return view('pages.pages', [
            'document' => $document,
            'data' => $pagesService->get($document),
            'sort' => $pagesService->getSortParams()
        ]);
    }

    /**
     * @param Documents $document
     * @param Pages $page
     * @param BlocksService $blocksService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Documents $document, Pages $page, BlocksService $blocksService)
    {

        $savedVariants = $blocksService->getSavedVariants($page);
        SEOMeta::setTitle(sprintf('Просмотр страницы “%s”', $page->name));

        return view('pages.detail', [
            'savedVariants' => $savedVariants,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Documents $document)
    {
        SEOMeta::setTitle('Добавление страницы');
        return view('pages.page_add', [
            'document' => $document
        ]);
    }

    /**
     * @param PagesRequest $request
     * @param PagesService $pagesService
     * @param Documents $document
     * @return RedirectResponse
     */
    public function store(PagesRequest $request, PagesService $pagesService, Documents $document)
    {
        try {
            $pagesService->checkRules($document);
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
        $status = $pagesService->add($request->all(), $document);
        if ($status) {
            return redirect()->route('documents.pages.index', ['document' => $document->id])->with('success', true);
        } else {
            return redirect()->back();
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     */
    public function edit(Documents $document, Pages $page)
    {
        SEOMeta::setTitle('Свойства страницы');
        return view('pages.page_properties', [
            'document' => $document,
            'page' => $page
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PagesRequest $request, Documents $document, PagesService $pagesService, Pages $page)
    {
        $status = $pagesService->update($document, $page, $request->all());
        if ($status) {
            return redirect()->route('documents.pages.index', ['document' => $document->id])->with('success', true);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Documents $document, Pages $page, PagesService $pagesService)
    {
        $pagesService->delete($page);
        return view('pages.pages', [
            'document' => $document,
            'data' => $pagesService->get($document),
            'sort' => $pagesService->getSortParams()
        ]);
    }
}
