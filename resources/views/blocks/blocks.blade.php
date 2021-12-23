@extends('layout.user')

@section('content')
    <div class="content-block">
        <div class="table-block">
            <div class="table-wrapper">
                <table class="table-fixed tablesorter">
                    <thead>
                    <tr>
                        <th style="min-width: 60px; width: 60px;">{{__('blocks.number')}}
                            <x-table.pagination field="id" :sort="$sort" :data="$data" route="blocks.index"/>
                        </th>
                        <th style="min-width: 200px; width: 1180px;">{{__('blocks.name')}}
                            <x-table.pagination field="name" :sort="$sort" :data="$data" route="blocks.index"/>
                        </th>
                        <th align="right" style="min-width: 100px; width: 140px;"
                            data-sorter="false">{{__('blocks.variants')}}</th>
                        <th align="right" style="width: 125px;">{{__('blocks.created_at')}}
                            <x-table.pagination field="created_at" :sort="$sort" :data="$data" route="blocks.index"/>
                        </th>
                        <th align="right" style="width: 125px;">{{__('blocks.updated_at')}}
                            <x-table.pagination field="updated_at" :sort="$sort" :data="$data" route="blocks.index"/>
                        </th>
                        <th align="center" data-sorter="false">{{__('blocks.action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td><strong>{{$item->formatted_id}}</strong></td>
                            <td><a href="{{route('blocks.types.index', ['block' => $item->id])}}">{{$item->name}}</a>
                            </td>
                            <td align="right">{{$item->variantsCount()}}</td>
                            <td align="right">{{$item->created_at}}</td>
                            <td align="right">{{$item->updated_at}}</td>
                            <td>
                                <div class="tools">
                                    <ul class="tools-list">
                                        <li>
                                            <a href="{{route('blocks.edit', ['block' => $item->id])}}" class="tool"><i
                                                    class="icon-settings"></i>{{__('blocks.btn_property')}}</a>
                                        </li>

                                        @if($item->variantsCount() < 1)
                                            <li>
                                                <a href="javascript:void(0);" class="tool"
                                                   data-title="{{$item->name}}"
                                                   data-action="{{route('blocks.destroy', ['block' => $item->id])}}">
                                                    <i class="icon-trash-basket"></i>{{__('blocks.btn_delete')}}
                                                </a>
                                            </li>
                                        @endif
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

    <div class="notification" id="save-notification-add" style="background-color: #7DC970;">
        {{__('blocks.notification_save')}}
    </div>


    <form class="modal confirmation-modal" id="remove-modal" action="" method="POST">
        @csrf
        @method('DELETE')
        <h4>{{__('blocks.title_accept')}}</h4>
        <p id="titleForm"></p>
        <div class="modal-buttons">
            <button type="button" class="btn btn-gray btn-tiny modal-btn"
                    onclick="$.fancybox.close()">{{__('blocks.btn_cancel')}}</button>
            <a href="javascript:void(0)" class="btn btn-red btn-tiny modal-btn"
               data-delete>{{__('blocks.btn_delete')}}</a>
        </div>
    </form>

@endsection

@section('btn')
    <div class="controls">
        <a href="{{route('blocks.create')}}"
           class="btn btn-accent btn-small btn-control btn-add">{{__('blocks.btn_add_block')}}</a>
    </div>
@endsection

@section('notification')
    @if(session()->has('success'))
        <script>
            notificate('#save-notification-add');
        </script>
    @endif
@endsection
