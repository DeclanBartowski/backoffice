@extends('layout.user')

@section('content')
    <div class="content-block">
        <div class="text-block">
            @if(isset($savedVariants) && $savedVariants)
                @foreach($savedVariants as $variant)
                    <div class="unit-text-item" style="border-bottom:none">
                    <p><strong>#{{$variant->getRelation('block')->formatted_id}}-{{$variant->number}}</strong></p>
                    {!! $variant->detail_actual !!}
                    </div>
                @endforeach
            @else
                Блоки не найдены
            @endif
        </div>
    </div>

@endsection


