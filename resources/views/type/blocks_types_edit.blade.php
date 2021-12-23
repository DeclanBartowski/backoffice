@extends('layout.user')

@section('content')

    <div class="content-block">
        <div class="module-box box">
            <div class="module-item module-item-big">
                <form action="{{route('blocks.types.update', ['block' => $block->id, 'type' => $type->id])}}"
                      id="formCreate" class="module-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="field-item module-field-item">
                        <label for="moduleName"
                               class="field-name field-name-small">{{__('blocks_type.form_field_name')}}</label>
                        <input type="text" class="field" name="name" required="" value="{{$type->name}}"
                               id="moduleName"  maxlength="100">
                    </div>
                    <div class="field-item module-field-item">
                        <h4 class="field-name field-name-small">{{__('blocks_type.form_load')}}</h4>
                        <div class="field-file">
                            <span class="field-file-text"></span>
                            <label class="btn file-load-btn">
                                <input type="file" id="fileChange" name="preview"
                                       accept="image/x-png,image/png,image/jpeg">
                                {{__('blocks_type.form_choice')}}
                            </label>
                        </div>
                    </div>
                    <select name="status" id="status" hidden>
                        <option value="">all</option>
                        <option value="draft">draft</option>
                        <option value="public">public</option>
                    </select>
                </form>
            </div>
            <div class="module-item module-item-flex" id="previewBlocks">
                <h4>{{__('blocks_type.form_preview_picture')}}</h4>
                @if(!empty($type->preview))
                    <img id="previewImage" src="{{$type->preview}}" alt="">
                @endif
            </div>
            <div class="module-item">
                <h4>{{__('blocks_type.form_rules')}}</h4>
                <div class="checkbox-group">
                    @foreach($tariffs as $tariff)
                        <label class="checkbox">
                            <input type="checkbox" @if(isset($type->tariffs) && $type->tariffs && in_array($tariff->id, $type->tariffs)) checked
                                   @endif form="formCreate" name="tariffs[]" value="{{$tariff->id}}">
                            <span>{{$tariff->name}}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="module-editor">
            <h4 class="field-name field-name-small">{{__('blocks_type.form_preview_text')}}</h4>
            <textarea name="detail" form="formCreate" id="editor1" cols="30" rows="10"
                      style="height: 200px">{!! $type->detail !!}</textarea>
        </div>
    </div>

    <div class="notification" id="remove-notification-error" style="background-color: #FF0000;">
        {{__('blocks_type.form_error')}}
    </div>

@endsection

@section('btn')
    <div class="controls">
        <a href="{{route('blocks.types.index', ['block' => $block->id])}}"
           class="btn btn-gray btn-small btn-control btn-cancel">{{__('blocks_type.form_cancel')}}</a>
        <a href="javascript:void(0);" class="btn btn-orange btn-small btn-control btn-save"
           data-status="draft">{{__('blocks_type.form_draft')}}</a>
        <a href="javascript:void(0);" class="btn btn-purple btn-small btn-control btn-publicate"
           data-status="public">{{__('blocks_type.form_publish')}}</a>
    </div>
@endsection

@section('notification')
    @if($errors->any())
        <script>
            notificate('#remove-notification-error');
        </script>
    @endif
@endsection

@section('cke')
    @include('partial.cke')
@endsection
