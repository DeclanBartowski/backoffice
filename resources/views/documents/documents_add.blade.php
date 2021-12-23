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
        <form action="{{route('documents.store')}}" class="edit-form" method="POST">
            @csrf
            <div class="field-item">
                <label for="documentName" class="field-name field-name-small">{{__('documents.title')}}</label>
                <input type="text" class="field" name="title" required=""  maxlength="100" id="documentName">
            </div>
            <div class="field-item">
                <label for="documentDescription" class="field-name field-name-small">{{__('documents.description')}}</label>
                <textarea class="field-textarea" maxlength="500" name="description" id="documentDescription" required=""></textarea>
            </div>
            @if(auth()->user()->is_admin)
            <div class="edit-form-footer">
                <label class="switcher">
                    <input type="checkbox" name="public">
                    <span class="switcher-text">{{__('documents.public')}}</span>
                </label>
            </div>
            @endif
        </form>
    </div>

@endsection

@section('btn')
    <div class="controls">
        <a href="{{route('documents.index')}}" class="btn btn-gray btn-small btn-control btn-cancel">{{__('documents.cancel')}}</a>
        <a href="javascript:void(0)" class="btn btn-green btn-small btn-control btn-save" data-submit>{{__('documents.save')}}</a>
    </div>
@endsection
