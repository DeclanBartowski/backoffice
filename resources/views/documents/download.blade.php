<h3>{{$document->name}}</h3>
@if(isset($document->pages) && $document->pages)
    @foreach($document->pages as $page)
        @if(isset($page->savedVariants) && $page->savedVariants)
            <h4>{{$page->name}}</h4>
            @foreach($page->savedVariants as $variant)
                <div class="unit-text-item" style="border-bottom:none">
                <p><strong>#{{$variant->getRelation('block')->formatted_id}}-{{$variant->number}}</strong>
                </p>
                {!! $variant->detail_actual !!}
                </div>
            @endforeach
        @endif
    @endforeach
@endif
