@extends('layout.guest')
@section('content')
    <div class="authorization-block">
        <h1>{{__('auth.title')}}</h1>
        <h3>{{__('auth.title_register')}}</h3>
        <form action="{{route('register_post')}}" class="authorization-form" method="POST">
            @csrf
            <div class="field-item">
                <label for="email" class="field-name">{{__('auth.email_field')}}</label>
                <input type="email" name="email" class="field field-big" placeholder="yourname@company.com" required id="email">
            </div>
            <div class="field-support">
                <label class="checkbox support-checkbox">
                    <input type="checkbox" class="js-checkbox-validate">
                    <span>{{__('auth.desc_btn')}}</span>
                </label>
            </div>
            <div class="authorization-form-footer">
                <button type="submit" class="btn btn-accent authorization-form-btn" disabled>{{__('auth.btn_register')}}</button>
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
