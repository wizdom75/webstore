@extends('layouts.app')

@section('title', 'homepage')

@section('data-page-id', 'home')

@section('content')

    <div class="home">
        <!--<div class="orbit" role="region" aria-label="Favorite Space Pictures" data-orbit data-options="animInFromLeft:fade-in; animInFromRight:fade-in; animOutToLeft:fade-out; animOutToRight:fade-out;">
            <ul class="orbit-container">
                <button class="orbit-previous"><span class="show-for-sr">Previous Slide</span>&#9664;&#xFE0E;</button>
                <button class="orbit-next"><span class="show-for-sr">Next Slide</span>&#9654;&#xFE0E;</button>
                <li class="is-active orbit-slide">
                    <img class="orbit-image" src="{{ getenv('APP_URL') }}/images/sliders/slide_1.png" alt="Space">
                   <figcaption class="orbit-caption">All stock ready for dispatch</figcaption>
                </li>
                <li class="orbit-slide">
                    <img class="orbit-image" src="{{ getenv('APP_URL') }}/images/sliders/slide_2.png" alt="Space">
                   <figcaption class="orbit-caption">Lets Rock!</figcaption>
                </li>
                <li class="orbit-slide">
                    <img class="orbit-image" src="{{ getenv('APP_URL') }}/images/sliders/slide_3.png" alt="Space">
                   <figcaption class="orbit-caption">Wide selection of breakers in stock!</figcaption>
                </li>

            </ul>
            <nav class="orbit-bullets">
                <button class="is-active" data-slide="0"><span class="show-for-sr">First slide details.</span><span class="show-for-sr">Current Slide</span></button>
                <button data-slide="1"><span class="show-for-sr">Second slide details.</span></button>
                <button data-slide="2"><span class="show-for-sr">Third slide details.</span></button>
            </nav>
        </div>-->

        @include('includes.message')
        <section class="display-products grid-container" data-token="{{ $token }}" id="root">


            <!--<div v-html=" blurb.body "></div>-->

            <br/>
            <h2>Featured products</h2>
            <div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-4">

                <div class="cell" v-cloak v-for="feature in featured">

                    <a :href="'{{ getenv('APP_URL') }}/product/' + feature.id">
                        <div class="card" data-equalizer-watch>
                            <div class="card-section">
                                <img :src="'{{ getenv('APP_URL') }}/'+ feature.image_path" width="100%" height="200">
                            </div>
                            <div class="card-section">
                                <p>@{{ stringLimit(feature.name, 18) }}</p>
                                <a :href="'{{ getenv('APP_URL') }}/product/' + feature.id" class="button more expanded">
                                    See more
                                </a>
                               <button v-if="feature.quantity > 0" @click.prevent="addToCart(feature.id)" class="button cart expanded">
                                    $@{{ feature.price }} - Add to cart
                                </button>
                                <button v-else class="button warning expanded" disabled>
                                    Out of stock
                                </button>
                            </div>
                        </div>
                    </a>

                </div>
            </div>

            <h2>Product picks</h2>
            <div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-4">

                <div class="cell" v-cloak v-for=" product in products">
                    <a :href="'{{ getenv('APP_URL') }}/product/' + product.id">
                        <div class="card" data-equalizer-watch>
                            <div class="card-section">
                                <img :src="'{{ getenv('APP_URL') }}/'+ product.image_path" width="100%" height="200">
                            </div>
                            <div class="card-section">
                                <p>@{{ stringLimit(product.name, 18) }}</p>
                                <a :href="'{{ getenv('APP_URL') }}/product/' + product.id" class="button more expanded">
                                    See more
                                </a>
                                <button v-if="product.quantity > 0" @click.prevent="addToCart(product.id)" class="button cart expanded">
                                    $@{{ product.price }} - Add to cart
                                </button>
                                <button v-else class="button warning expanded" disabled>
                                    Out of stock
                                </button>
                            </div>
                        </div>
                    </a>
                </div>
            </div>


           <div class="text-center">

               <img v-show="loading" src="{{ getenv('APP_URL') }}/images/loading.gif" style="font-size: 3rem; padding-bottom: 3rem;
                position: fixed; top: 60%; bottom: 20%;">

           </div>
        </section>
    </div>
@stop