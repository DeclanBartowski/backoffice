@extends('layout.user')

@section('notification')
    @if(session()->has('success'))
        <script>
            notificate('#save-notification-add');
        </script>
    @endif
@endsection

@section('content')
    <div class="content-block">
        <div class="table-block">
            <div class="table-wrapper">
                <table class="table-fixed tablesorter">
                    <thead>
                    <tr>
                        <th style="min-width: 60px; width: 60px;">#
                            <x-table.pagination field="id" :sort="$sort" :data="$data" route="documents.index" />
                        </th>
                        <th style="min-width: 200px; width: 478px;">Название
                            <x-table.pagination field="name" :sort="$sort" :data="$data" route="documents.index" />
                        </th>
                        <th style="min-width: 300px; width: 775px;" data-sorter="false">Описание</th>
                        <th style="width: 120px;" align="right">Статус
                            <x-table.pagination field="status" :sort="$sort" :data="$data" route="documents.index" />

                        </th>
                        <th align="right" style="width: 125px;">Создан
                            <x-table.pagination field="created_at" :sort="$sort" :data="$data" route="documents.index" />

                        </th>
                        <th align="right" style="width: 125px;">Изменен
                            <x-table.pagination field="updated_at" :sort="$sort" :data="$data" route="documents.index" />
                        </th>
                        <th align="center" data-sorter="false">Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr>
                        <td><strong>{{Auth::id() == $item->user_id?$item->number:'-'}}</strong></td>
                        <td><a href="{{!$item->status || Auth::id() == $item->user_id?route('documents.pages.index', ['document' => $item->id]):route('documents.show', ['document' => $item->id])}}">{{$item->name}}</a></td>
                        <td>{{$item->description}}</td>
                        <td align="right">
                            @if($item->status)
                            <span class="status" style="background-color: #7F63F4">публичный</span>
                            @else
                                <span class="status" style="background-color: #F3AF00">персональный</span>
                            @endif
                        </td>
                        <td align="right">{{$item->created_at}}</td>
                        <td align="right">{{$item->updated_at}}</td>
                        <td>
                            <div class="tools">
                                <ul class="tools-list">
                                    @if(!$item->status || Auth::id() == $item->user_id)
                                    <li>
                                        <a href="{{route('documents.edit', ['document' => $item->id])}}" class="tool"><i class="icon-settings"></i>Свойства</a>
                                    </li>
                                        @endif

                                    <li>
                                        <a href="{{route('documents.show', ['document' => $item->id])}}" class="tool"><i class="icon-view"></i>Просмотр</a>
                                    </li>
                                        @if(!$item->status || Auth::id() == $item->user_id)
                                    <li>
                                        <a href="{{route('documents.download', ['document' => $item->id])}}" class="tool"><i class="icon-download"></i>Скачать</a>
                                    </li>
                                        @endif

                                    @if($item->pagesCount() < 1 && (!$item->status || Auth::id() == $item->user_id))
                                    <li>
                                        <a href="javascript:void(0);" class="tool"
                                           data-title="{{$item->name}}"
                                           data-action="{{route('documents.destroy', ['document' => $item->id])}}" >
                                            <i class="icon-trash-basket"></i>Удалить
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
        Сохранено
    </div>



    <form class="modal confirmation-modal"  id="remove-modal" action="" method="POST">
        @csrf
        @method('DELETE')
        <h4>Требуется подтверждение</h4>
        <p id="titleForm"></p>
        <div class="modal-buttons">
            <button type="button" class="btn btn-gray btn-tiny modal-btn" onclick="$.fancybox.close()">Отмена</button>
            <a href="javascript:void(0)" class="btn btn-red btn-tiny modal-btn" data-delete>Удалить</a>
        </div>
    </form>

@endsection

@section('btn')
    <div class="controls">
        <a href="{{route('documents.create')}}" class="btn btn-accent btn-small btn-control btn-add">Добавить документ</a>
    </div>
@endsection
