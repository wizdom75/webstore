@extends('layouts.app')
@section('title', 'Sign up, It\'s free')
@section('data-page-id', 'auth')

@section('content')
    <div class="auth" id="auth">
        <section class="register_form">
            <div class="row">
                <div class="small-12 medium-7 medium-centered">
                    <h2 class="text-center">Create account</h2>
                    @include('includes.message')

                    <form action="{{ getenv('APP_URL') }}/register" method="post">
                        <input type="text" name="fullname" placeholder="Your fullname here."
                               value="{{ \App\classes\Request::old('post', 'fullname') }}">

                        <input type="text" name="email" placeholder="Your Email address."
                               value="{{ \App\classes\Request::old('post', 'email') }}">

                        <input type="text" name="username" placeholder="Your username."
                               value="{{ \App\classes\Request::old('post', 'username') }}">

                        <input type="password" name="password" placeholder="Your password.">
                        <textarea name="address" placeholder="Your address">{{ \App\classes\Request::old('post', 'address') }}</textarea>
                        <input type="hidden" name="token" value="{{ \App\classes\CSRFToken::_token() }}">

                        <button class="button float-right">Register</button>
                    </form>
                    <p>Already registered? Click <a href="{{ getenv('APP_URL') }}/login">here</a> to login </p>
                </div>
            </div>
        </section>
    </div>

@stop