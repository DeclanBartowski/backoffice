@extends('layout.user')

@section('content')
    <div class="content-block">
        <form action="{{route('profile_post')}}" class="edit-form edit-form-small" method="POST">
            @csrf
            <div class="field-item">
                <label for="userEmail" class="field-name field-name-small">{{__('profile.email')}}</label>
                <input type="email" name="email" class="field" required="" id="userEmail">
                <div class="field-item-info">{{__('profile.description')}}</div>
            </div>
            <div class="field-item">
                <label for="userPassword" class="field-name field-name-small">{{__('profile.password')}}</label>
                <input type="password" name="password" class="field" required="" id="userPassword">
            </div>
        </form>
    </div>

    <div class="notification" id="remove-notification-error" style="background-color: #FF0000;">
        {{__('profile.modal_error_data')}}
    </div>

    <div class="notification" id="remove-notification-error-link" style="background-color: #FF0000;">
        {{__('profile.modal_link_deactivate')}}
    </div>

    <div class="notification" id="save-notification-sender" style="background-color: #7DC970;">
        {{__('profile.modal_send_notification')}}
    </div>

    <div class="notification" id="save-notification-email-active" style="background-color: #7DC970;">
        {{__('profile.modal_email_change')}}
    </div>

@endsection

@section('btn')
    <div class="controls">
        <a class="btn btn-green btn-small btn-control btn-save" data-submit>{{__('profile.save')}}</a>
    </div>
@endsection

@section('notification')
    @if($errors->any())
        <script>
            notificate('#remove-notification-error');
        </script>
    @endif

    @if(session()->has('success'))
        <script>
            notificate('#save-notification-sender');
        </script>
    @endif


    @if(session()->has('email-active'))
        <script>
            notificate('#save-notification-email-active');
        </script>
    @endif

    @if(session()->has('email-error'))
        <script>
            notificate('#remove-notification-error-link');
        </script>
    @endif

@endsection
