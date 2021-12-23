@extends('layout.user')

@section('content')
    <div class="content-block">
        <form action="{{route('blocks.update', ['block' => $data->id])}}" class="edit-form" action="{{route('blocks.store')}}" method="POST">
            @csrf
            @method('PUT')
            <div class="field-item">
                <label for="blockName" class="field-name field-name-small">{{__('blocks.title')}}</label>
                <input type="text" name="name" class="field" required="" value="{{$data->name}}" id="blockName"  maxlength="100">
            </div>
            <div class="field-item">
                <h4 class="field-name field-name-small">{{__('blocks.rules')}}</h4>
                <div class="radio-group">
                    @foreach($rules as $key => $rule)
                        <label class="radio">
                            <input type="radio" @if($data->rules == $key) checked @endif name="rules" value="{{$key}}">
                            <span>{{$rule}}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </form>
    </div>
@endsection

@section('btn')
    <div class="controls">
        <a href="{{route('blocks.index')}}" class="btn btn-gray btn-small btn-control btn-cancel">{{__('blocks.cancel')}}</a>
        <a href="javascript:void(0)" class="btn btn-green btn-small btn-control btn-save" data-submit>{{__('blocks.save')}}</a>
    </div>
@endsection
