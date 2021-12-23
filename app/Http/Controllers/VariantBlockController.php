<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlocksTypeRequest;
use App\Models\Blocks;
use App\Models\VariantBlocks;
use App\Services\BlocksTypeService;
use App\Services\TariffsService;
use Illuminate\Http\Request;

class VariantBlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request, Blocks $block, BlocksTypeService $blocksTypeService)
    {
        if($request->has('sort_field') && $request->has('sort_order')) {
            $blocksTypeService->setSortParams($request->get('sort_field'), $request->get('sort_order'));
        }

        \SEOMeta::setTitle(sprintf('Варианты блока “%s“', $block->name));
        return view('type.blocks_types', [
            'block' => $block,
            'data' => $blocksTypeService->get($block),
            'sort' => $blocksTypeService->getSortParams()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create(Blocks $block, TariffsService $tariffsService)
    {
        \SEOMeta::setTitle('Добавление варианта блока');
        return view('type.blocks_types_add',
            [
                'tariffs' => $tariffsService->get(),
                'block' => $block

            ]
        );
    }

    /**
     * Store a newly created resource in st orage.
     *

     */
    public function store(BlocksTypeRequest $request, Blocks $block, BlocksTypeService $blocksTypeService)
    {
        return $blocksTypeService->add($request, $block);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VariantBlocks  $variantBlocks
     * @return \Illuminate\Http\Response
     */
    public function show(VariantBlocks $variantBlocks, Blocks $block, TariffsService $tariffsService)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(Blocks $block, VariantBlocks $type, TariffsService $tariffsService)
    {
        \SEOMeta::setTitle('Редактирование варианта блока');
        return view('type.blocks_types_edit',
            [
                'tariffs' => $tariffsService->get(),
                'block' => $block,
                'type' => $type

            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *

     */
    public function update(Blocks $block, VariantBlocks $type, BlocksTypeRequest $request, BlocksTypeService $blocksTypeService)
    {
        return $blocksTypeService->add($request, $block, $type->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VariantBlocks  $variantBlocks
     */
    public function destroy(Blocks $block, VariantBlocks $type, BlocksTypeService $blocksTypeService)
    {
        $blocksTypeService->delete($type);
        return view('type.blocks_types', [
            'block' => $block,
            'data' => $blocksTypeService->get($block),
            'sort' => $blocksTypeService->getSortParams()
        ]);
    }
}
