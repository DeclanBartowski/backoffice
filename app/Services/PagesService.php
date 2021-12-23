<?php

namespace App\Services;

use App\Models\Documents;
use App\Models\Pages;
use Illuminate\Support\Facades\Auth;

class PagesService
{
    protected $sortField = 'updated_at';
    protected $sortOrder = 'DESC';

    public function add($params, Documents $document): bool
    {
        $page = new Pages();
        $page->name = $params['title'];
        $page->description = $params['description'];
        $page->document_id = $document->id;
        return $page->save();
    }

    public function checkRules($document)
    {
        $user = Auth::user();
        $limit = $user->tariff->limit['pages']['value']??0;
        $document->load('pages');
        if ($limit > 0) {
            if ($limit < $document->pages->count() + 1) {
                throw new \Exception(sprintf('Максимальное количество страниц в документе в Вашем тарифе : %s', $limit));
            }
        }
    }

    public function get(Documents $document)
    {
        $sortParams = $this->getSortParams();
        return Pages::where('document_id', $document->id)->orderBy($sortParams['field'],
            $sortParams['order'])->paginate(10);
    }

    public function update(Documents $document, Pages $page, $params)
    {
        $page->name = $params['title'];
        $page->description = $params['description'];
        $page->document_id = $document->id;
        return $page->save();
    }


    public function delete(Pages $page)
    {
        $page->delete();
    }

    public function getSortParams(): array
    {
        return [
            'field' => session('page_sort_field', $this->sortField),
            'order' => session('page_sort_order', $this->sortOrder),
        ];
    }

    public function setSortParams($field, $order)
    {
        session([
            'page_sort_field' => $field,
            'page_sort_order' => $order,
        ]);
    }

}
