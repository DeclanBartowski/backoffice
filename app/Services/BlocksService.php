<?php

namespace App\Services;

use App\Models\Blocks;
use App\Models\BlocksUser;
use App\Models\Pages;
use App\Models\User;
use App\Models\VariantBlocks;
use Illuminate\Support\Facades\Auth;

class BlocksService
{

    protected $sortField = 'ID';
    protected $sortOrder = 'ASC';

    public function getSortParams(): array
    {
        return [
            'field' => session('block_sort_field', $this->sortField),
            'order' => session('block_sort_order', $this->sortOrder),
        ];
    }

    public function setSortParams($field, $order)
    {
        session([
            'block_sort_field' => $field,
            'block_sort_order' => $order,
        ]);
    }

    public function add($params): bool
    {
        $block = new Blocks();
        $block->fill($params);
        return $block->save();
    }

    public function get()
    {
        $sortParams = $this->getSortParams();
        return Blocks::orderBy($sortParams['field'], $sortParams['order'])->paginate(10);
    }

    public function update(Blocks $blocks, $params)
    {
        $blocks->fill($params);
        return $blocks->save();
    }


    public function delete(Blocks $block)
    {
        $block->delete();
    }

    public function getBlocks()
    {
        return Blocks::orderBy('id', 'asc')->has('variants')->with('variants', function ($q) {
            $q->where('status', 'public');
        })
            ->get();
    }

    public function getSavedVariants($page)
    {
        $page->load('savedPage');
        $arSavedVariants = [];
        $savedPage = $page->getRelation('savedPage')->where('user_id', Auth::id())->first();

        if ($savedPage && isset($savedPage->blocks_page) && $savedPage->blocks_page) {
            $variants = VariantBlocks::whereIn('id', $savedPage->blocks_page)->with('block')->get();
            foreach ($savedPage->blocks_page as $id) {
                if ($variant = $variants->find($id)) {
                    $arSavedVariants[] = $variant;
                }
            }
        }
        return $arSavedVariants;
    }

    public function checkRules($document, $page, $variant, $request, $block,$isSave = false)
    {
        if (isset($variant->locked) && $variant->locked) {
            throw new \Exception('Не доступен в Вашем тарифе');
        }

        $user = Auth::user();
        /*$blockLimit = $user->tariff->limit['block']??0;
        $variantLimit = $user->tariff->limit['variant_block']??0;*/

        if (!$user->relationLoaded('userSavedPages')) {
            $user->load('userSavedPages');
        }
        if($isSave){
            $arCurrentPageVariants = $request['variants'] ?? [];
        }else{
            $arCurrentPageVariants = array_merge($request['variants'] ?? [], [$variant->id]);
        }

        $currentPageVariantsCount = count($arCurrentPageVariants);
        $savedVariantsCount = 0;
        $arSavedVariants = [];
        if ($user->userSavedPages) {
            $user->userSavedPages->where('page_id', '!=',
                $page->id)->keyBy('page_id')->pluck('blocks_page')->each(function ($item) use (
                &$savedVariantsCount,
                &$arSavedVariants
            ) {
                $arSavedVariants = array_merge($arSavedVariants, $item ?? []);
                $savedVariantsCount += count($item);
            });
        }
        /*$totalVariantsCount = $savedVariantsCount + $currentPageVariantsCount;

        if ($variantLimit['value']>0 && $variantLimit['value'] < $totalVariantsCount) {
            throw new \Exception(sprintf('Превышено максимальное количество использованных типов блоков. Доступно: %s. Использовано: %s',
                $variantLimit['value'], $totalVariantsCount));
        }*/
        $arSavedVariants = array_unique(array_merge($arSavedVariants, $arCurrentPageVariants));
        /*if ($arSavedVariants) {
            $blockCount = VariantBlocks::whereIn('id', $arSavedVariants)->pluck('block_id')->unique()->count();

            if ($blockLimit['value']>0 && $blockLimit['value'] < $blockCount) {
                throw new \Exception(sprintf('Превышено максимальное количество использованных блоков. Доступно: %s. Использовано: %s',
                    $blockLimit['value'], $blockCount));
            }
        }*/


        if (isset($block->rules) && $block->rules && isset(Blocks::RULES[$block->rules]) && Blocks::RULES[$block->rules]) {
            $block->load('variants');
            $arBlockVariantsIds = $block->getRelation('variants')->pluck('id')->toArray();
            switch ($block->rules) {
                case 'document_only_one':
                    if (!$document->relationLoaded('pages')) {
                        $document->load('pages');
                    }
                    $pageIds = $document->pages->pluck('id');
                    if ($pageIds) {
                        $arSavedVariants = [];
                        BlocksUser::where('user_id', $user->id)->whereIn('page_id',
                            $pageIds->toArray())->get()->each(function ($item) use (&$arSavedVariants) {
                            if (isset($item->blocks_page) && $item->blocks_page) {
                                $arSavedVariants = array_merge($arSavedVariants, $item->blocks_page);
                            }
                        });
                        $arSavedVariantsCurrent = array_merge($arSavedVariants, $arCurrentPageVariants);
                        if (count(array_intersect($arSavedVariantsCurrent, [$variant->id])) > 1) {
                            throw new \Exception(sprintf('%s (%s)',Blocks::RULES[$block->rules],$variant->name));
                        }
                    }


                    break;
                case 'page_only_one':

                    if (isset($arCurrentPageVariants) && $arCurrentPageVariants) {
                        $cnt = 0;
                        foreach ($arCurrentPageVariants as $pageVariant) {
                            if (in_array($pageVariant, $arBlockVariantsIds)) {
                                $cnt++;
                            }
                        }
                        if ($cnt > 1) {
                            throw new \Exception(sprintf('%s (%s)',Blocks::RULES[$block->rules],$variant->name));
                        }
                    }

                    break;
            }
        }
    }

}
