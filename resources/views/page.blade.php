@extends('layouts.app')
@section('title') {{ $page->title }}@endsection
@section('data-page-id', 'page')

@section('content')
    <div class="product" id="page" data-token="{{ $token }}" data-id="{{ $page->slug }}">
        <div class="text-center">
            <img v-show="loading" src="{{ getenv('APP_URL') }}/images/loading.gif">
        </div>
        <section class=" content item-container" v-if="loading == false">
            <div class="row column">
                <nav aria-label="You are here:" role="navigation">
                    <ul class="breadcrumbs">
                        <li><a href="/">Home</a></li>
                        <li class="disabled">{{ $page->title }}</li>
                    </ul>
                </nav>

            </div>
            <div class="grid-x grid-margin-x">

                <div class="small-12 medium-12 large-12 cell">
                    @include('includes.message')
                    <h2>{{ $page->title }}</h2>

                    <p v-html=" page.body "></p>

                </div>


            </div>
        </section>


    </div>
    
@stop