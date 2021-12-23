@extends('layout.user')
@section('btn')
            <div class="controls">
                <a href="{{route('documents.pages.index',['document'=>$document])}}" id="tq_cancel" class="btn btn-gray btn-small btn-control btn-cancel">Отмена</a>
                <a href="javascript:void(0)" class="btn btn-green btn-small btn-control btn-save" id="tq_save_page" data-url="{{route('block_pages_save',['document'=>$document,'page'=>$page])}}">Сохранить</a>
                <a href="{{route('documents.pages.show',['document'=>$document,'page'=>$page])}}" class="btn btn-purple btn-small btn-control btn-view">Просмотр страницы</a>
            </div>
@endsection
@section('content')
    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function (){
                $('#tq-error').html('{!! implode('<br>',$errors->all()) !!}');
                notificate('#tq-error')
            });
        </script>
    @endif
    <div class="unit">
        @if(isset($blocks) && !$blocks->isEmpty())
        <div class="unit-column">
            <div class="unit-column-head">
                <div class="unit-column-number">#</div>
                <h4>Название блока</h4>
            </div>
            <div class="unit-column-body">
                <div class="unit-items custom-vertical-scroll">
                    @foreach($blocks as $block)
                    <div class="unit-item" data-href="#tab-{{$block->id}}">
                        <span class="unit-item-number">{{$block->formatted_id}}</span>
                        <div class="unit-item-title">{{$block->name}} </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="unit-column unit-column-small">
            <div class="unit-column-head">
                <h4>Тип блока</h4>
            </div>
            <div class="unit-column-hidden">
                @foreach($blocks as $block)
                <div class="unit-column-body" id="tab-{{$block->id}}">
                    <div class="unit-blocks custom-vertical-scroll">
                        @foreach($block->variants as $variant)
                            @if(isset($variant->locked) && $variant->locked)
                                <div class="unit-block unit-block-locked">
                                    <img src="{{asset(isset($variant->preview) && $variant->preview?$variant->preview:'images/dest/image-fallback.png')}}" alt="{{$variant->name}}">
                                    <div class="unit-block-info">
                                        <i class="icon-lock"></i>Недоступно в вашем тарифе
                                    </div>
                                    <div class="unit-block-text">
                                        <p><strong>#{{$block->formatted_id}}-{{$variant->number}}</strong> {{$variant->name}}</p>
                                    </div>
                                </div>
                            @else
                                <div class="unit-block" data-block-variant="{{route('block_pages_variant',['document'=>$document,'page'=>$page,'variant'=>$variant->id])}}">
                                    <img src="{{asset(isset($variant->preview) && $variant->preview?$variant->preview:'images/dest/image-fallback.png')}}" alt="{{$variant->name}}">
                                    <div class="unit-block-text">
                                        <p><strong>#{{$block->formatted_id}}-{{$variant->number}}</strong> {{$variant->name}}</p>
                                    </div>
                                </div>
                            @endif

                        @endforeach

                    </div>
                </div>
                @endforeach

            </div>
        </div>
        <div class="unit-column unit-column-wide">
            <div class="unit-column-head">
                <h4>Блоки страницы</h4>
            </div>
            <div class="unit-column-hidden">
                <div class="unit-column-body" style="display: block;">
                    <div class="unit-text custom-vertical-scroll" id="tq_result_page">
                        @if(isset($savedVariants) && $savedVariants)
                        @each('pages.variant',$savedVariants,'variant')
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @else
            Блоки не найдены
        @endif
    </div>

@endsection


