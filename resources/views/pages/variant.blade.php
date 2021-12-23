@if(isset($variant) && $variant)
<div class="unit-text-item" data-variant-id="{{$variant->id}}">
    <p><strong>#{{$variant->getRelation('block')->formatted_id}}-{{$variant->number}}</strong></p>
    {!! $variant->detail_actual !!}
    <div class="unit-tеxt-controls">
        <button class="unit-text-btn unit-text-btn-up icon-carret-top" type="button"></button>
        <button class="unit-text-btn unit-text-btn-down icon-carret-bottom active" type="button"></button>
        <button class="unit-text-btn unit-text-btn-remove icon-trash-basket" type="button"></button>
    </div>
</div>
@endif
