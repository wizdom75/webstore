@extends('layouts.app')

@section('title') {{ $slug->name }}@endsection

@section('data-page-id', 'category')

@section('content')

    <div class="category">
        <section class="filter-simple display-products grid-container" id="category"  data-token="{{ $token }}"  data-id="{{ $slug->slug }}"  >
            <div class="row column">
                <nav aria-label="You are here:" role="navigation">
                    <ul class="breadcrumbs">
                        <li><a href="/">Home</a></li>
                        <li class="disabled">{{ $slug->name }}</li>

                    </ul>
                </nav>
            </div>
            @include('includes.message')

            <div class="button-group round">
                <div>
                <a href="/category/{{ $slug->slug }}"><button class="button  @if($_SERVER['REQUEST_URI'] !== "/category/".$slug->slug) hollow @endif " data-filter="all">All</button></a>


                    @foreach($subcategories as $subcat)
                        <a href="/subcategory/{{$subcat->slug}}">
                            <button class="button @if($_SERVER['REQUEST_URI'] !== "/subcategory/".$subcat->slug) hollow @endif " data-filter=" {{ $subcat->slug }} ">
                                {{ $subcat->name }}
                            </button>
                        </a>
                    @endforeach

                </div>




            </div>

            <div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-4">

                <div v-if="products.length > 0" class="cell" v-cloak v-for=" product in products">
                        <a :href="'{{ getenv('APP_URL') }}/product/' + product.id">
                            <div class="card " data-equalizer-watch>
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

                <div v-else>
                    <h2>This category has no products</h2>
                </div>



            </div>

            <div class="text-center">

                <img v-show="loading" src="{{ getenv('APP_URL') }}/images/loading.gif" style="font-size: 3rem; padding-bottom: 3rem;
                position: fixed; top: 60%; bottom: 20%;">

            </div>
        </section>


        <!-- End -->


    </div>



@stop