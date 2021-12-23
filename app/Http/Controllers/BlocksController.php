<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlocksRequest;
use App\Http\Requests\DocumentsRequest;
use App\Models\Blocks;
use App\Models\BlocksUser;
use App\Models\Documents;
use App\Models\Pages;
use App\Models\VariantBlocks;
use App\Services\BlocksService;
use App\Services\DocumentsService;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlocksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, BlocksService $blocksService)
    {
        if ($request->has('sort_field') && $request->has('sort_order')) {
            $blocksService->setSortParams($request->get('sort_field'), $request->get('sort_order'));
        }
        SEOMeta::setTitle('Список блоков');
        return view('blocks.blocks', [
            'data' => $blocksService->get(),
            'sort' => $blocksService->getSortParams()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEOMeta::setTitle('Добавление нового блока');
        return view('blocks.block_add', [
            'rules' => Blocks::RULES
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlocksRequest $request
     * @param BlocksService $blocksService
     * @return RedirectResponse
     */
    public function store(BlocksRequest $request, BlocksService $blocksService)
    {
        $status = $blocksService->add($request->all());
        if ($status) {
            return redirect()->route('blocks.index')->with('success', true);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     */
    public function edit(Blocks $block)
    {
        SEOMeta::setTitle('Свойства блока');
        return view('blocks.block_properties', [
            'data' => $block,
            'rules' => Blocks::RULES
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlocksRequest $request, Blocks $block, BlocksService $blocksService)
    {
        $status = $blocksService->update($block, $request->all());
        if ($status) {
            return redirect()->route('blocks.index')->with('success', true);
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
    public function destroy(Blocks $block, BlocksService $blocksService)
    {
        $blocksService->delete($block);
        return view('blocks.blocks', [
            'data' => $blocksService->get(),
            'sort' => $blocksService->getSortParams()
        ]);
    }

    public function userBlock(Documents $document, Pages $page, BlocksService $blocksService)
    {
        if($document->user_id != Auth::id())
            abort('404');
        $blocks = $blocksService->getBlocks();
        $savedVariants = $blocksService->getSavedVariants($page);
        SEOMeta::setTitle(sprintf('Блоки страницы “%s”', $page->name));

        return view('pages.blocks', [
            'document' => $document,
            'page' => $page,
            'blocks' => $blocks,
            'savedVariants' => $savedVariants,
        ]);
    }

    public function getVariantHtml(
        Documents $document,
        Pages $page,
        VariantBlocks $variant,
        Request $request,
        BlocksService $blocksService
    ) {
        $variant->load('block');
        $block = $variant->getRelation('block');
        $blocksService->checkRules($document, $page, $variant, $request->all(), $block);

        return view('pages.variant', compact('variant'));
    }

    public function savePage(Documents $document, Pages $page, Request $request, BlocksService $blocksService)
    {
        $arVariants = $request->input('variants', []);
        if ($arVariants) {
            $variants = VariantBlocks::whereIn('id', $arVariants)->with('block')->get();
            if ($variants) {
                $arErrors = [];
                foreach ($variants as $variant) {
                    try {
                        $blocksService->checkRules($document, $page, $variant, $request->all(),$variant->block,true);
                    } catch (\Exception $exception) {
                        $arErrors[] = $exception->getMessage();
                    }
                }
                if ($arErrors) {
                    return back()->withErrors(implode('<br>', $arErrors));

                }
            } else {
                return back()->withErrors('Указанные варианты блоков не найдены');
            }
        }
        $page->load('savedPage');
        $item = BlocksUser::firstOrNew(['user_id' => Auth::id(), 'page_id' => $page->id]);
        $item->blocks_page = $arVariants;
        $page->savedPage()->save($item);
        return redirect()->route('documents.pages.index', ['document' => $document])->with('notification',
            '#save-notification');
    }

}
