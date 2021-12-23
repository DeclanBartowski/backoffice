<ul class="menu">
    <li  @if(Route::is('documents.index')) class="active" @endif><a href="{{route('documents.index')}}"><i class="icon-documents"></i>Документы</a></li>
    @if(auth()->user()->is_admin)
        <li @if(Route::is('blocks.index')) class="active" @endif><a href="{{route('blocks.index')}}"><i class="icon-blocks"></i>Блоки</a></li>
        <li  @if(Route::is('users')) class="active" @endif><a href="{{route('users')}}"><i class="icon-users"></i>Пользователи</a></li>
        <li  @if(Route::is('tariffs_list')) class="active" @endif><a href="{{route('tariffs_list')}}"><i class=""></i>Тарифы</a></li>
    @endif
</ul>
