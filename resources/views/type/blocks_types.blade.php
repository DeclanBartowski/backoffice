@extends('layout.user')

@section('content')
    <div class="content-block">
        <div class="table-block">
            <div class="table-wrapper">
                <table class="table-fixed table-blocks tablesorter">
                    <thead>
                    <tr>
                        <th style="min-width: 60px; width: 82px;" data-sorter="false">{{__('blocks_type.index')}}
                            <x-table.pagination field="ID" :sort="$sort" :data="$data" route="blocks.types.index" :paramsRoute="['block' => $block->id]" />
                        </th>
                        <th style="min-width: 200px; width: 970px;" data-sorter="false">{{__('blocks_type.variant')}}</th>
                        <th style="min-width: 255px; width: 255px;" data-sorter="false">{{__('blocks_type.preview')}}</th>
                        <th align="center" style="width: 120px;">{{__('blocks_type.status')}}
                            <x-table.pagination field="status" :sort="$sort" :data="$data" route="blocks.types.index" :paramsRoute="['block' => $block->id]" />
                        </th>
                        <th align="right" style="width: 125px;">{{__('blocks_type.created')}}
                            <x-table.pagination field="created_at" :sort="$sort" :data="$data" route="blocks.types.index" :paramsRoute="['block' => $block->id]" />
                        </th>
                        <th align="right" style="width: 125px;">{{__('blocks_type.updated')}}
                            <x-table.pagination field="updated_at" :sort="$sort" :data="$data" route="blocks.types.index" :paramsRoute="['block' => $block->id]" />
                        </th>
                        <th align="center" data-sorter="false">{{__('blocks_type.action')}}</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($data as $item)
                        <tr>
                            <td><strong>{{$block->formatted_id}}-{{$item->number}}</strong></td>
                            <td><a href="{{route('blocks.types.edit', ['block' => $block->id, 'type' => $item->id])}}">{{$item->name}}</a></td>
                            <td>
                                @if(!empty($item->preview))
                                    <img src="{{$item->preview}}" alt="">
                                @endif
                            </td>
                            <td align="center">
                                @if($item->status == 'draft')
                                    <span class="status" style="background-color: #F3AF00">{{__('blocks_type.draft')}}</span>
                                @endif
                                @if($item->status == 'public')
                                    <span class="status" style="background-color: #7F63F4">{{__('blocks_type.publish')}}</span>
                                @endif

                            </td>
                            <td align="right">{{$item->created_at}}</td>
                            <td align="right">{{$item->updated_at}}</td>
                            <td>
                                <div class="tools">
                                    <ul class="tools-list">
                                        <li><a href="javascript:void(0)"
                                               data-title="{{$item->name}}"
                                               data-action="{{route('blocks.types.destroy', ['block' => $block->id, 'type' => $item->id])}}"
                                               class="tool"><i
                                                    class="icon-trash-basket"></i>{{__('blocks_type.delete')}}</a></li>
                                    </ul>
                                    <button class="tools-btn icon-dots" type="button"></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            {{$data->links()}}
        </div>
    </div>

    <form class="modal confirmation-modal"  id="remove-modal" action="" method="POST">
        @csrf
        @method('DELETE')
        <h4>{{__('blocks_type.accept')}}</h4>
        <p id="titleForm"></p>
        <div class="modal-buttons">
            <button type="button" class="btn btn-gray btn-tiny modal-btn" onclick="$.fancybox.close()">{{__('blocks_type.cancel')}}</button>
            <a href="javascript:void(0)" class="btn btn-red btn-tiny modal-btn" data-delete>{{__('blocks_type.delete')}}</a>
        </div>
    </form>

@endsection

@section('btn')
    <div class="controls">
        <a href="{{route('blocks.types.create', ['block' => $block->id])}}"
           class="btn btn-accent btn-small btn-control btn-add">{{__('blocks_type.add')}}</a>
    </div>
@endsection

@section('notification')
    @if(session()->has('public'))
        <script>
            notificate('#published-notification');
        </script>
    @endif

    @if(session()->has('draft'))
        <script>
            notificate('#save-draft-notification');
        </script>
    @endif
@endsection
