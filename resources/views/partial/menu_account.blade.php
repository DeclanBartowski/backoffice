<div class="account">
    <a href="{{route('profile')}}" class="account-link @if(Route::is('profile')) active @endif"><i class="icon-user-circle"></i>Профиль</a>
    <a href="{{route('tariffs')}}" class="account-link @if(Route::is('tariffs')) active @endif"><i class="icon-money"></i>Тариф</a>
    <a href="{{route('logout')}}" class="account-link"><i class="icon-logout"></i>Выход</a>
</div>
