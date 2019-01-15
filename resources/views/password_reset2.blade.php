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

                    <form action="{{ getenv('APP_URL') }}/reset-password" method="post">
                        <input type="password" name="password" placeholder="Enter your new password">
                        <input type="password" name="password_confirm" placeholder="Re-enter your new password">
                        <input type="hidden" name="reset_token" value="{{ $_SERVER['REQUEST_URI']  }}">
                        <input type="hidden" name="token" value="{{ \App\classes\CSRFToken::_token() }}">

                        <button class="button float-right">Reset password</button>
                    </form>
                </div>
            </div>
        </section>
    </div>

@stop