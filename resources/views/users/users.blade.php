@extends('layout.user')
@section('content')
    <div class="content-block">
        <div class="table-block">
            <div class="table-wrapper">
                <table class="table-fixed tablesorter">
                    <thead>
                    <tr>
                        <th style="min-width: 60px; width: 60px;">#
                            <x-table.pagination field="users.id" :sort="$sort" :data="$data" route="users" />
                        </th>
                        <th style="min-width: 200px; width: 1250px;">E-mail</th>
                        <th data-sorter="false">Тариф
                            <x-table.pagination field="tariffs.name" :sort="$sort" :data="$data" route="users" />
                        </th>
                        <th style="width: 120px;" align="right">Статус
                            <x-table.pagination field="tariffs_user_blocks.active_to" :sort="$sort" :data="$data" route="users" />
                        </th>
                        <th align="right" style="width: 125px;">Создан
                            <x-table.pagination field="users.created_at" :sort="$sort" :data="$data" route="users" />
                        </th>
                        <th align="right" style="width: 125px;">Активность
                            <x-table.pagination field="tariffs_user_blocks.active_to" :sort="$sort" :data="$data" route="users" />
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $user)
                        <tr>
                            <td><strong>{{$user->id}}</strong></td>
                            <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                            <td>{{$user->name}}</td>
                            <td align="right">
                                @if(empty($user->active_to) || (Carbon\Carbon::parse($user->active_to)->diffInHours(\Carbon\Carbon::now(), false) > 0))
                                    <span class="status" style="background-color: #FF0000">блокирован</span>
                                @else
                                    <span class="status" style="background-color: #65A65A">активен</span>
                                @endif
                            </td>
                            <td align="right">{{$user->created_at}}</td>
                            <td align="right">{{$user->active_to}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{$data->links()}}
        </div>
    </div>
@endsection
