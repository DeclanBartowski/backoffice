<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentsRequest;
use App\Models\Documents;
use App\Services\DocumentsService;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request, DocumentsService $documentsService)
    {
        if ($request->has('sort_field') && $request->has('sort_order')) {
            $documentsService->setSortParams($request->get('sort_field'), $request->get('sort_order'));
        }

        SEOMeta::setTitle('Список документов');
        return view('users.documents', [
            'data' => $documentsService->get(),
            'sort' => $documentsService->getSortParams()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEOMeta::setTitle('Добавление документа');
        return view('documents.documents_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DocumentsRequest $request
     * @param DocumentsService $documentsService
     * @return RedirectResponse
     */
    public function store(DocumentsRequest $request, DocumentsService $documentsService)
    {
        try {
            $documentsService->checkRules();
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
        $status = $documentsService->add($request->all());
        if ($status) {
            return redirect()->route('documents.index')->with('success', true);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     */
    public function edit(Documents $document)
    {
        SEOMeta::setTitle('Свойства документа');

        return view('documents.documents_properties', [
            'data' => $document
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentsRequest $request, Documents $document, DocumentsService $documentsService)
    {
        $status = $documentsService->update($document, $request->all());
        if ($status) {
            return redirect()->route('documents.index')->with('success', true);
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
    public function destroy(Documents $document, DocumentsService $documentsService)
    {
        $documentsService->delete($document);
        return view('users.documents', [
            'data' => $documentsService->get(),
            'sort' => $documentsService->getSortParams()
        ]);
    }


    public function show(Documents $document, DocumentsService $documentsService)
    {
        $documentsService->getDocumentData($document);

        SEOMeta::setTitle('Просмотр документа');
        return view('documents.detail', [
            'document' => $document
        ]);
    }

    public function download(Documents $document, DocumentsService $documentsService)
    {
        ini_set("pcre.backtrack_limit", "100000000");
        $documentsService->getDocumentData($document);
        $mpdf = new \Mpdf\Mpdf();
        ob_start();

        $html = view('documents.download', [
            'document' => $document
        ])->render();
        ob_end_clean();
        $stylesheet = file_get_contents(asset('css/app.min.css'));
        $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        $mpdf->Output(sprintf('%s.pdf', $document->name), 'D');
    }
}
