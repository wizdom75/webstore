@extends('layouts.app')
@section('title', 'Your shopping cart')
@section('data-page-id', 'cart')
@section('stripe-checkout')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endsection
@section('content')
    <div class="shopping_cart" id="shopping_cart">

        <div class="text-center">
            <img v-show="loading" src="{{ getenv('APP_URL') }}/images/loading.gif">
        </div>

        <section class="items" v-if="loading == false">
            <div class="row">
                <div class="small-12">
                    <h2 v-if="fail" v-text="message"></h2>
                    <div v-else>
                        <h2>Your cart</h2>
                        <table class="hover unstriped">
                            <thead class="text-left">
                            <tr>
                                <th>#</th><th>Product name</th><th>$ Unit price</th>
                                <th>Qty</th><th>Total</th><th>Action</th>
                            </tr>

                            </thead>
                            <tbody>
                            <tr v-for="item in items">
                                <td class="medium-text-center">
                                    <a :href="'{{getenv('APP_URL')}}/product/' + item.id">
                                        <img :src="'{{ getenv('APP_URL') }}/' + item.image"  height="60px" width="60px" alt="@{{item.name}}">
                                    </a>
                                </td>
                                <td>
                                    <h5><a :href="'{{ getenv('APP_URL') }}/product/' + item.id">@{{ item.name }}</a></h5>
                                    Status:
                                    <span v-if="item.stock > 1" style="color: #00aa00">In stock</span>
                                    <span v-else style="color: #ff0000">Out of stock</span>
                                </td>
                                <td>$@{{ item.price }}</td>
                                <td>
                                    <button v-if="item.quantity > 1" @click="updateQuantity(item.id, '-')" style="cursor: pointer; color: #ffae00">
                                        <i class="fa fa-minus-square" aria-hidden="true"></i>
                                    </button>
                                    @{{ item.quantity }}
                                    <button v-if="item.stock > item.quantity" @click="updateQuantity(item.id, '+')" style="cursor: pointer; color: #00aa00">
                                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                                    </button>

                                </td>
                                <td>$@{{ item.total }}</td>
                                <td class="text-center">
                                    <button @click="removeItem(item.index)">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table>
                            <tr>
                                <td valign="top">
                                    <div class="input-group">
                                        <input type="text" name="coupon" class="input-group-field" placeholder="coupon code">
                                        <div class="input-group-button">
                                            <button class="button">Apply</button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <table class="unstriped">
                                        <tr>
                                            <td><h6>Subtotal:</h6></td>
                                            <td class="text-right"><h6>$@{{ cartTotal }}</h6></td>
                                        </tr>
                                        <tr>
                                            <td><h6>Discount amt:</h6></td>
                                            <td class="text-right"><h6>$0.00</h6></td>
                                        </tr>
                                        <tr>
                                            <td><h6>Tax:</h6></td>
                                            <td class="text-right"><h6>$0.00</h6></td>
                                        </tr>
                                        <tr>
                                            <td><h6>Total:</h6></td>
                                            <td class="text-right"><h6>$@{{ cartTotal }}</h6></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <div class="text-right">
                            <a href="{{ getenv('APP_URL') }}" class="button secondary">
                                Continue shopping &nbsp;<i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            </a>
                            <button @click.prevent="checkout" v-if="authenticated" class="button success">
                                Checkout &nbsp; <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                            </button>
                            <span v-else>
                                <a href="{{ getenv('APP_URL') }}/login" class="button success">
                                    Checkout &nbsp; <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                                </a>
                            </span>

                            <span class="hide" id="properties"
                                  data-customer-email="{{ user()->email }}"
                                  data-stripe-key="{{ \App\classes\Session::get('publishable_key') }}">

                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

@stop