@extends('layout.user')
@section('content')
    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function (){
                $('#tq-error').html('{!! implode('<br>',$errors->all()) !!}');
                notificate('#tq-error')
            });
        </script>
    @endif
    <div class="content-block">
        <form action="{{route('documents.pages.store', ['document' => $document->id])}}" class="edit-form"
              method="POST">
            @csrf
            <div class="field-item">
                <label for="pageName" class="field-name field-name-small">{{__('page.title')}}</label>
                <input type="text" name="title" class="field" required="" id="pageName" maxlength="100">
            </div>
            <div class="field-item">
                <label for="pageDescription" class="field-name field-name-small">{{__('page.description')}}</label>
                <textarea class="field-textarea" name="description" maxlength="500" id="pageDescription" required=""></textarea>
            </div>
        </form>
    </div>
@endsection
@section('btn')
    <div class="controls">
        <a href="{{route('documents.pages.index', ['document' => $document->id])}}"
           class="btn btn-gray btn-small btn-control btn-cancel">{{__('page.cancel')}}</a>
        <a href="javascript:void(0)" class="btn btn-green btn-small btn-control btn-save"
           data-submit>{{__('page.save')}}</a>
    </div>
@endsection
