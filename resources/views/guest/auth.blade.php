@extends('layout.guest')

@section('notification')
    @if(session()->has('success'))
        <script>
            notificate('#save-notification-add');
        </script>
    @endif
@endsection

@section('content')
    <div class="authorization-block">
        <h1>{{__('auth.title')}}</h1>
        <h3>{{__('auth.page_name')}}</h3>
        <form action="{{route('auth_post')}}" class="authorization-form" method="POST" id="authForm">
            @csrf
            <div class="field-item">
                <label for="email" class="field-name">{{__('auth.email_field')}}</label>
                <input type="email" name="email" class="field field-big" placeholder="yourname@company.com" required
                       id="email">
            </div>
            <div class="field-item">
                <label for="password" class="field-name">{{__('auth.password_field')}}</label>
                <input type="password" name="password" class="field field-big" placeholder="****************" required
                       id="password">
            </div>
            <div class="field-support">
                <label class="checkbox">
                    <input type="checkbox" name="remember" checked="">
                    <span>{{__('auth.remember')}}</span>
                </label>
                <a href="{{route('restore')}}" class="support-link">{{__('auth.forgot_password')}}</a>
            </div>
            <div class="authorization-form-footer">
                <button class="btn btn-accent authorization-form-btn">{{__('auth.enter')}}</button>
            </div>
        </form>
        <p>{{__('auth.no_account')}} <a href="{{route('register')}}">{{__('auth.register')}}</a></p>
    </div>
    <div class="notification" id="remove-notification" style="background-color: #FF0000;">
        {{__('auth.errors')}}
    </div>
    <div class="notification" id="save-notification-add" style="background-color: #7DC970;">
        {{__('auth.success_email')}}
    </div>
@endsection

