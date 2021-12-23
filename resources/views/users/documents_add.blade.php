@extends('layout.user')

@section('content')

    <div class="content-block">
        <form action="#" class="edit-form">
            <div class="field-item">
                <label for="documentName" class="field-name field-name-small">Название</label>
                <input type="text" class="field" required="" id="documentName">
            </div>
            <div class="field-item">
                <label for="documentDescription" class="field-name field-name-small">Описание</label>
                <textarea class="field-textarea" id="documentDescription" required=""></textarea>
            </div>
            <div class="edit-form-footer">
                <label class="switcher">
                    <input type="checkbox">
                    <span class="switcher-text">Это публичный документ</span>
                </label>
            </div>
        </form>
    </div>

@endsection

@section('btn')
    <div class="controls">
        <a href="documents.html" class="btn btn-gray btn-small btn-control btn-cancel">Отмена</a>
        <a href="#save-notification"
           class="btn btn-green btn-small btn-control btn-save js-confirmation-btn">Сохранить</a>
    </div>
@endsection
