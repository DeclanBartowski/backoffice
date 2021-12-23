@extends('layout.user')

@section('notification')
    @if(session()->has('success'))
        <script>
            notificate('#save-notification-add');
        </script>
        @elseif(session()->has('notification'))
        <script>
            notificate('{{session()->get('notification')}}');
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
                            <x-table.pagination field="id" :sort="$sort" :data="$data" route="documents.pages.index"
                                                :paramsRoute="['document' => $document->id]"/>
                        </th>
                        <th style="min-width: 200px; width: 478px;">Название
                            <x-table.pagination field="name" :sort="$sort" :data="$data" route="documents.pages.index"
                                                :paramsRoute="['document' => $document->id]"/>
                        </th>
                        <th style="min-width: 300px; width: 880px;" data-sorter="false">Описание</th>
                        <th align="right" style="width: 125px;">Создан
                            <x-table.pagination field="created_at" :sort="$sort" :data="$data"
                                                route="documents.pages.index"
                                                :paramsRoute="['document' => $document->id]"/>
                        </th>
                        <th align="right" style="width: 125px;">Изменен
                            <x-table.pagination field="updated_at" :sort="$sort" :data="$data"
                                                route="documents.pages.index"
                                                :paramsRoute="['document' => $document->id]"/>
                        </th>
                        <th align="center" data-sorter="false">Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td><strong>{{$item->number}}</strong></td>
                            <td><a href="{{route('block_pages',['document'=>$document,'page'=>$item])}}">{{$item->name}}</a></td>
                            <td>{{$item->description}}</td>
                            <td align="right">{{$item->created_at}}</td>
                            <td align="right">{{$item->updated_at}}</td>
                            <td>
                                <div class="tools">
                                    <ul class="tools-list">
                                        <li>
                                            <a href="{{route('documents.pages.edit', ['document' => $document->id, 'page' => $item->id])}}"
                                               class="tool">
                                                <i class="icon-settings"></i>Свойства
                                            </a>
                                        </li>
                                        <li><a href="javascript:void(0)"
                                               data-title="{{$item->name}}"
                                               data-action="{{route('documents.pages.destroy', ['document' => $document->id, 'page' => $item->id])}}"

                                               class="tool"><i
                                                    class="icon-trash-basket"></i>Удалить</a></li>
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

    <form class="modal confirmation-modal" id="remove-modal" action="" method="POST">
        @csrf
        @method('DELETE')
        <h4>Требуется подтверждение</h4>
        <p id="titleForm">At vero eos et accusamus et iusto odio dignissimos At vero eos et accusamus et iusto odio
            dignissimos</p>
        <div class="modal-buttons">
            <button type="button" class="btn btn-gray btn-tiny modal-btn" onclick="$.fancybox.close()">Отмена</button>
            <a href="javascript:void(0)" class="btn btn-red btn-tiny modal-btn" data-delete>Удалить</a>
        </div>
    </form>

@endsection

@section('btn')
    <div class="controls">
        <a href="{{route('documents.pages.create', ['document' => $document->id])}}"
           class="btn btn-accent btn-small btn-control btn-add">Добавить страницу</a>
    </div>
@endsection
