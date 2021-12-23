@extends('layout.user')
@section('content')
    <div class="content-block">
        <div class="rates">
            <div class="rates-items">
                <div class="rates-item">
                    <h4>{{__('tariffs.current')}} “{{$tariff->name}}”</h4>
                    <p>{{__('tariffs.active_to')}} @if(empty($tariff_user) || $tariff->default){{__('tariffs.free')}} @else {{$tariff_user->active_to}} @endif</p>
                </div>
                <div class="rates-item">
                    <h4>{{__('tariffs.limit')}}</h4>
                    @foreach($tariff->limit as $limit)
                        <p>{{implode(': ',$limit )}}</p>
                    @endforeach
                </div>
                <div class="rates-item">
                    <h4>{{__('tariffs.status')}}</h4>
                    <p>{{__('tariffs.create_documents')}} {{$status['docs']}}</p>
                    <p>{{__('tariffs.create_pages')}} {{$status['pages']}}</p>
                </div>
            </div>
            <div class="rates-box box">
                @foreach($data as $item)
                    <form action="{{route('tariffs_post', ['tariff' => $item->id])}}" method="POST" class="rates-card">
                        @csrf
                        <h4>{{$item->name}}</h4>
                        @foreach($item->limit as $limit)
                            <div class="rates-card-info">{{implode(' - ',$limit )}}</div>
                        @endforeach
                        <div class="rates-card-info">{{__('blocks.blocks_count')}} - {{$item->statistic['blocks']}}</div>
                        <div class="rates-card-info">{{__('blocks.variants_count')}} - {{$item->statistic['variants']}}</div>
                        <div class="rates-card-price">{{$item->price}}₽</div>
                        @if($tariff->id == $item->id)
                            <button class="btn btn-green btn-small rates-card-btn" type="button"
                                    disabled>{{__('tariffs.current')}}
                            </button>
                        @else
                            <button class="btn btn-green btn-small rates-card-btn"
                                    type="submit">{{__('tariffs.next')}}</button>
                        @endif
                    </form>
                @endforeach
            </div>
        </div>
    </div>
@endsection
