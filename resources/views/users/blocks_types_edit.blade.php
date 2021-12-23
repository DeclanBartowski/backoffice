@extends('layout.user')

@section('content')

    <div class="content-block">
        <div class="module-box box">
            <div class="module-item module-item-big">
                <form action="#" class="module-form">
                    <div class="field-item module-field-item">
                        <label for="moduleName" class="field-name field-name-small">Название</label>
                        <input type="text" class="field" required="" id="moduleName">
                    </div>
                    <div class="field-item module-field-item">
                        <h4 class="field-name field-name-small">Загрузить обложку варианта</h4>
                        <div class="field-file">
                            <span class="field-file-text"></span>
                            <label class="btn file-load-btn">
                                <input type="file">
                                Обзор
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="module-item module-item-flex">
                <h4>Превью</h4>
                <img src="images/dest/image-vertical-fallback.png" alt="">
            </div>
            <div class="module-item">
                <h4>Условия</h4>
                <div class="checkbox-group">
                    <label class="checkbox">
                        <input type="checkbox" checked>
                        <span>Вариант блока доступен в “Тариф 1”</span>
                    </label>
                    <label class="checkbox">
                        <input type="checkbox" checked>
                        <span>Вариант блока доступен в “Тариф 2”</span>
                    </label>
                    <label class="checkbox">
                        <input type="checkbox" checked>
                        <span>Вариант блока доступен в “Тариф 3”</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="module-editor">
            <h4 class="field-name field-name-small">Описание варианта блока</h4>
        </div>
    </div>

@endsection

@section('btn')
    <div class="controls">
        <a href="blocks-types.html" class="btn btn-gray btn-small btn-control btn-cancel">Отмена</a>
        <a href="#save-draft-notification" class="btn btn-orange btn-small btn-control btn-save js-confirmation-btn">Сохранить
            черновик</a>
        <a href="#published-notification"
           class="btn btn-purple btn-small btn-control btn-publicate js-confirmation-btn">Опубликовать</a>
    </div>
@endsection
