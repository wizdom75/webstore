(function () {
    'use strict';

    WEBSTORE.product.cart = function () {

        var Stripe = StripeCheckout.configure({
            key: $('#properties').data('stripe-key'),
            locale: "auto",
            image: "/images/logos/logo.png",
            token: function (token) {
                var data = $.param({stripeToken: token.id, stripeEmail: token.email});

                axios.post('/cart/payment', data).then(function (response) {
                    $(".notify").css("display", "block").delay(4000).slideUp(300)
                        .html(response.data.success);
                    app.displayItems(200);
                }).catch(function (error) {
                    console.log(error);
                });
            }
        });

        var app = new Vue({
            el: '#shopping_cart',
            data: {
                items: [],
                cartTotal: 0,
                loading: false,
                fail: false,
                authenticated: false,
                message: '',
                amountInCents: 0
            },
            methods: {
                displayItems: function (time) {
                    this.loading = true;
                    setTimeout(function () {
                        axios.get('/cart/items').then(function (response) {
                            if(response.data.fail){
                                app.fail = true;
                                app.message = response.data.fail;
                                app.loading = false;
                            }else{
                                app.items = response.data.items;
                                app.cartTotal = response.data.cartTotal;
                                app.loading = false;
                                app.authenticated = response.data.authenticated;
                                app.amountInCents = response.data.amountInCents;
                            }
                        });
                    }, time);
                },
                updateQuantity: function (product_id, operator) {

                    var postData = $.param({product_id: product_id, operator: operator});

                    axios.post('/cart/update-qty', postData).then(function (response) {
                        app.displayItems(200);
                    });
                },
                removeItem: function (index) {
                    var postData = $.param({item_index:index});
                    axios.post('/cart/remove-item', postData).then(function (response) {
                        $(".notify").css("display", "block").delay(4000).slideUp(300)
                            .html(response.data.success);
                        app.displayItems(200);
                    });
                },
                checkout: function () {
                    Stripe.open({
                        name: "Rojo Hammer Inc.",
                        description: "Shopping cart items",
                        email: $('#properties').data('customer-email'),
                        amount: app.amountInCents,
                        zipCode: true
                    });
                }
                },
            created: function () {
                this.displayItems(2000);
            }
        });
    }
})();