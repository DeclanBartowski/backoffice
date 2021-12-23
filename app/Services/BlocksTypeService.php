<?php

namespace App\Services;

use App\Models\Blocks;
use App\Models\VariantBlocks;


class BlocksTypeService
{

    protected $sortField = 'ID';
    protected $sortOrder = 'ASC';

    protected function saveFile($request)
    {

        $originName = $request->file('preview')->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $request->file('preview')->getClientOriginalExtension();
        $fileName = $fileName . '_' . time() . '.' . $extension;
        $request->file('preview')->move(public_path('images/blocks'), $fileName);
        return asset('images/blocks/' . $fileName);
    }

    public function add($request, Blocks $block, $id = 0)
    {
        if ($id > 0) {
            $blocksType = VariantBlocks::find($id);
        } else {
            $blocksType = new VariantBlocks();
        }

        $blocksType->name = $request->get('name');
        $blocksType->tariffs = $request->get('tariffs');
        $blocksType->detail = $request->get('detail');
        $blocksType->status = $request->get('status');
        $blocksType->block_id = (int)$block->id;

        if ($request->hasFile('preview')) {
            $blocksType->preview = $this->saveFile($request);
        }

        $blocksType->save();

        if ($blocksType->status == 'public') {
            return redirect()->route('blocks.types.index', ['block' => $block->id])->with('public', true);
        }

        if ($blocksType->status == 'draft') {
            return redirect()->route('blocks.types.index', ['block' => $block->id])->with('draft', true);
        }
    }

    public function getID($block)
    {
        $result = 1;
        $currentID = VariantBlocks::where('block_id', $block)->orderBy('number', 'DESC')->first();
        if ($currentID) {
            $result = $currentID->number + 1;
        }
        return $result;
    }

    public function get(Blocks $block)
    {
        $sortParams = $this->getSortParams();
        return VariantBlocks::where('block_id', $block->id)->orderBy($sortParams['field'], $sortParams['order'])->paginate(10);
    }

    public function getSortParams(): array
    {
        return [
            'field' => session('block_type_sort_field', $this->sortField),
            'order' => session('block_type_sort_order', $this->sortOrder),
        ];
    }

    public function setSortParams($field, $order)
    {
        session([
            'block_type_sort_field' => $field,
            'block_type_sort_order' => $order,
        ]);
    }

    public function delete(VariantBlocks $variantBlocks) {
        $variantBlocks->delete();
    }

}
