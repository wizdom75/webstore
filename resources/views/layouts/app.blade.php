@extends('layouts.base')

@section('body')



     <!--Navigation-->

     @include('includes.nav')

    <!-- Site wrapper -->
    <div class="site_wrapper">
        @yield('content')


        <div class="notify text-center">

        </div>
    </div>

    @yield('footer')
     @include('includes.footer')
     {{-- @include('includes.get-quote-modal') --}}

@stop