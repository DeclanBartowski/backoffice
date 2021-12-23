@extends('layout.user')

@section('content')
    <div class="content-block">
        <form action="{{route('tariffs_detail_update', ['tariff' => $data->id])}}" method="POST" class="edit-form">
            @csrf
            <div class="field-item">
                <label for="blockName" class="field-name field-name-small">Название</label>
                <input type="text" name="name" class="field" required="" id="blockName" maxlength="100" value="{{$data->name}}">
            </div>
            <div class="field-item">
                <label for="blockPrice" class="field-name field-name-small">Цена</label>
                <input type="text" name="price" class="field" required="" id="blockPrice" value="{{$data->price}}">
            </div>

            <div class="field-item">
                <h4 class="field-name field-name-small">{{__('blocks.rules')}}</h4>
                <div class="radio-group">
                    <input type="text" name="limit[document][title]" value="{{$data->limit['document']['title']??''}}">
                    <input type="number" name="limit[document][value]" value="{{$data->limit['document']['value']??''}}">
                </div>
            </div>

            <div class="field-item">
                <div class="radio-group">
                    <input type="text" name="limit[pages][title]" value="{{$data->limit['pages']['title']??''}}">
                    <input type="number" name="limit[pages][value]" value="{{$data->limit['pages']['value']??''}}">
                </div>
            </div>
            <div class="field-item">
                <div class="radio-group">
                    <input type="text" value="{{__('blocks.blocks_count')}}" disabled>
                    <input type="number" value="{{$data->statistic['blocks']??0}}" disabled>
                </div>
            </div>
            <div class="field-item">
                <div class="radio-group">
                    <input type="text" value="{{__('blocks.variants_count')}}" disabled>
                    <input type="number" value="{{$data->statistic['variants']??0}}" disabled>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('btn')
    <div class="controls">
        <a href="{{route('tariffs_list')}}"
           class="btn btn-gray btn-small btn-control btn-cancel">{{__('blocks.cancel')}}</a>
        <a href="javascript:void(0)" class="btn btn-green btn-small btn-control btn-save"
           data-submit>{{__('blocks.save')}}</a>
    </div>
@endsection
