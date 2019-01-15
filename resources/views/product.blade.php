@extends('layouts.app')
@section('title') {{ $product->name }}@endsection
@section('data-page-id', 'product')

@section('content')
    <div class="product" id="product" data-token="{{ $token }}" data-id="{{ $product->id }}">
        <div class="text-center">
            <img v-show="loading" src="{{ getenv('APP_URL') }}/images/loading.gif">
        </div>
        <section class="item-container" v-if="loading == false">
            <div class="row column">
                <nav aria-label="You are here:" role="navigation">
                    <ul class="breadcrumbs">
                        <li><a href="/">Home</a></li>
                        <li><a :href="'{{ getenv('APP_URL') }}/category/' + category.slug">@{{ category.name }}</a></li>
                        <li><a :href="'{{ getenv('APP_URL') }}/subcategory/' + subCategory.slug">@{{ subCategory.name }}</a></li>
                        <li class="disabled">@{{ product.name }}</li>
                    </ul>
                </nav>
            </div>
            <div class="grid-x grid-margin-x">

                <div class="small-12 medium-5 large-4 cell">
                    <img :src="'{{ getenv('APP_URL') }}/' + product.image_path" width="100%" height="200">
                </div>

                <div class="small-12 medium-7 large-8 cell">
                    @include('includes.message')
                    <div class="product-details">
                        <h2> @{{ product.name }}</h2>
                        <p v-html=" product.description "></p>
                        <h2>$@{{ product.price }}</h2>
                       <button v-if="product.quantity > 0" @click.prevent="addToCart(product.id)" class="button button">
                            $@{{ product.price }} - Add to cart
                        </button>
                        <button v-else class="button warning" disabled>
                            Out of stock
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section class="home" v-if="loading == false">

            <div class="display-products grid-container">
                <h2>Related products</h2>
                <div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-4">

                    <div class="cell" v-cloak v-for=" similar in similarProducts">
                        <a :href="'{{ getenv('APP_URL') }}/product/' + similar.id">
                            <div class="card" data-equalizer-watch>
                                <div class="card-section">
                                    <img :src="'{{ getenv('APP_URL') }}/'+ similar.image_path" width="100%" height="200">
                                </div>
                                <div class="card-section">
                                    <p>@{{ stringLimit(similar.name, 15) }}</p>
                                    <a :href="'{{ getenv('APP_URL') }}/product/' + similar.id" class="button more expanded">
                                        See more
                                    </a>
                                    <button v-if="similar.quantity > 0" @click.prevent="addToCart(similar.id)" class="button cart expanded">
                                        $@{{ similar.price }} - Add to cart
                                    </button>
                                    <button v-else class="button warning expanded" disabled>
                                        Out of stock
                                    </button>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </section>
    </div>
    
@stop