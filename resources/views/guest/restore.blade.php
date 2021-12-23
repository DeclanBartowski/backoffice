@extends('layout.guest')
@section('content')
    <div class="authorization-block">
        <h1>{{__('auth.title')}}</h1>
        <h3>{{__('auth.title_restore')}}</h3>
        <form action="{{route('restore_post')}}" class="authorization-form" method="POST">
            @csrf
            <div class="field-item">
                <label for="email" class="field-name">{{__('auth.email_field')}}</label>
                <input type="email" name="email" class="field field-big js-field-validate" placeholder="yourname@company.com" required id="email">
            </div>
            <div class="authorization-form-footer">
                <button type="submit" class="btn btn-accent authorization-form-btn" disabled>{{__('auth.btn_restore')}}</button>
            </div>
        </form>
        <p>{{__('auth.account')}} <a href="{{route('auth')}}">{{__('auth.login')}}</a></p>
    </div>
    <div class="notification" id="remove-notification" style="background-color: #FF0000;">
        {{__('auth.errors')}}
    </div>
@endsection
@section('notification')
    @if($errors->any())
        <script>
            notificate('#remove-notification');
        </script>
    @endif
@endsection
