<?php

namespace App\Services;

use App\Models\Blocks;
use App\Models\Documents;
use App\Models\VariantBlocks;
use Illuminate\Support\Facades\Auth;

class DocumentsService
{

    protected $sortField = 'updated_at';
    protected $sortOrder = 'DESC';

    public function add($params): bool
    {
        $document = new Documents();
        $document->name = $params['title'];
        $document->description = $params['description'];
        $document->status = isset($params['public']);
        $document->user_id = auth()->user()->id;
        return $document->save();
    }

    public function checkRules()
    {
        $user = Auth::user();
        $limit = $user->tariff->limit['document']['value']??0;
        if ($limit > 0) {
            $user->load('userDocuments');

            if ($limit < $user->userDocuments->count() + 1) {
                throw new \Exception(sprintf('Максимальное количество документов в Вашем тарифе : %s', $limit));
            }
        }
    }

    public function getDocumentData(&$document)
    {
        $document->load('pages', 'pages.savedPage');
        foreach ($document->pages as $key => &$page) {
            if ($savedPage = $page->savedPage->first()) {
                if ($savedPage->blocks_page) {
                    $page->savedVariants = null;
                    $savedPages[] = $savedPage;
                } else {
                    $document->pages->forget($key);
                }
            } else {
                $document->pages->forget($key);
            }
        }
        unset($page);

        if (isset($savedPages) && $savedPages) {
            $arVariantsIds = [];
            foreach ($savedPages as $page) {
                $arVariantsIds = array_merge($arVariantsIds, $page->blocks_page ?? []);
            }
            $variants = VariantBlocks::whereIn('id', $arVariantsIds)->with('block')->get()->keyBy('id');
            foreach ($document->pages as $key => &$page) {
                $arVariants = [];
                foreach ($page->savedPage->first()->blocks_page as $id) {
                    if ($variant = $variants->find($id)) {
                        $arVariants[] = $variant;
                    }
                }
                $page->savedVariants = $arVariants;
            }
            unset($page);
        }
    }

    public function getSortParams(): array
    {
        return [
            'field' => session('document_sort_field', $this->sortField),
            'order' => session('document_sort_order', $this->sortOrder),
        ];
    }

    public function setSortParams($field, $order)
    {
        session([
            'document_sort_field' => $field,
            'document_sort_order' => $order,
        ]);
    }

    public function get()
    {
        $sortParams = $this->getSortParams();
        return Documents::where('user_id', auth()->user()->id)->orWhere('status',1)->orderBy($sortParams['field'],
            $sortParams['order'])->paginate(10);
    }

    public function update(Documents $documents, $params)
    {
        $documents->name = $params['title'];
        $documents->description = $params['description'];
        $documents->status = isset($params['public']);
        return $documents->save();
    }


    public function delete(Documents $documents)
    {
        $documents->delete();
    }

}
