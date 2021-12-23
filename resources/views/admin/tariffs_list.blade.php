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
                        <th style="min-width: 60px; width: 60px;">#</th>
                        <th style="min-width: 200px; width: 478px;">Название</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr>
                        <td><strong>{{$loop->iteration}}</strong></td>
                        <td><a href="{{route('tariffs_detail', ['tariff' => $item->id])}}">{{$item->name}}</a></td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="notification" id="save-notification-add" style="background-color: #7DC970;">
        Сохранено
    </div>



@endsection


