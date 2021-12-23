@extends('layout.user')

@section('content')
    <div class="content-block">
        <form action="{{route('documents.pages.update', ['document' => $document->id, 'page' => $page->id])}}" class="edit-form"
              method="POST">
            @csrf
            @method('PUT')
            <div class="field-item">
                <label for="pageName" class="field-name field-name-small">{{__('page.title')}}</label>
                <input type="text" name="title" class="field" required="" id="pageName" value="{{$page->name}}" maxlength="100">
            </div>
            <div class="field-item">
                <label for="pageDescription" class="field-name field-name-small">{{__('page.description')}}</label>
                <textarea class="field-textarea" name="description" id="pageDescription" required="" maxlength="500">{{$page->description}}</textarea>
            </div>
        </form
@endsection

@section('btn')
            <div class="controls">
                <a href="{{route('documents.pages.index', ['document' => $document->id])}}"
                   class="btn btn-gray btn-small btn-control btn-cancel">{{__('page.cancel')}}</a>
                <a href="javascript:void(0)" class="btn btn-green btn-small btn-control btn-save"
                   data-submit>{{__('page.save')}}</a>
            </div>
@endsection
