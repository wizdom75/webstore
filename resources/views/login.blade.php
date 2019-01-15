@extends('layouts.app')
@section('title', 'Login')
@section('data-page-id', 'auth')

@section('content')
    <div class="auth" id="auth">
        <section class="login_form">
            <div class="row">
                <div class="small-12 medium-7 medium-centered">
                    <h2 class="text-center">Login</h2>
                    @include('includes.message')

                    <form action="{{ getenv('APP_URL') }}/login" method="post">
                        <input type="text" name="username" placeholder="Your username or email"
                               value="{{ \App\classes\Request::old('post', 'username') }}">

                        <input type="password" name="password" placeholder="Your password.">
                        <input type="hidden" name="token" value="{{ \App\classes\CSRFToken::_token() }}">

                        <button class="button float-right">Login</button>
                    </form>
                    <p><a href="{{ getenv('APP_URL') }}/reset/password">Forgot password? </a> </p>
                    <p><a href="{{ getenv('APP_URL') }}/register">Not yet a member? </a> </p>
                </div>
            </div>
        </section>
    </div>

@stop