@extends('layouts.app')
@section('title', 'Password reset')
@section('data-page-id', 'auth')

@section('content')
    <div class="auth" id="auth">
        <section class="password_reset_form">
            <div class="row">
                <div class="small-12 medium-7 medium-centered">
                    <h2 class="text-center">Reset your password</h2>
                    @include('includes.message')

                    <form action="{{ getenv('APP_URL') }}/reset/password" method="post">
                        <input type="text" name="username" placeholder="Your username or email"
                               value="{{ \App\classes\Request::old('post', 'username') }}">
                        <input type="hidden" name="token" value="{{ \App\classes\CSRFToken::_token() }}">

                        <button class="button float-right">Send password reset</button>
                    </form>
                    <p> <a href="{{ getenv('APP_URL') }}/register">Not yet a member?</a> </p>
                </div>
            </div>
        </section>
    </div>

@stop