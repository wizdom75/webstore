(function(){
    'use strict'

    WEBSTORE.homeslider.homePageProducts = function () {
        var app = new Vue({

            el: '#root',
            data: {
                featured: [],
                products: [],
                blurb: [],
                banners: [],
                count: 0,
                checkout: 0,
                loading: false
            },
            methods:{
                getFeaturedProducts: function(){
                    this.loading = true;
                    axios.all(
                        [
                            axios.get('/featured'), axios.get('/get-products'), axios.get('/get-banners'), axios.get('/get-blurb')
                        ]
                    ).then(axios.spread(function(featuredResponse, productsResponse, bannerResponse, blurbResponse){
                        app.featured = featuredResponse.data.featured;
                        app.products = productsResponse.data.products;
                        app.banners = bannerResponse.data.banners;
                        app.blurb = blurbResponse.data.blurb;
                        app.blurbCount = blurbResponse.data.blurb.count;
                        app.count = productsResponse.data.products.count;
                        app.checkout = featuredResponse.data;
                        app.loading = false;
                    }));

                },
                stringLimit: function(string, value){
                    return WEBSTORE.module.truncateString(string, value);
                },
                addToCart: function (id) {
                    WEBSTORE.module.addItemToCart(id, function (message) {
                        $(".notify").css("display", "block").delay(4000).slideUp(300)
                            .html(message);
                    });

                },
                loadMoreProducts: function () {
                    var token = $('.display-products').data('token');
                    this.loading = true;
                    var data = $.param({next: 4, token: token, count: app.count});
                    axios.post('/load-more', data)
                        .then(function (response) {
                            app.products = response.data.products;
                            app.count = response.data.count;
                            app.loading = false;
                        });
                }
            },
            created: function(){
                this.getFeaturedProducts();
            },
            mounted: function () {
                $(window).scroll(function () {
                    if($(window).scrollTop() + $(window).height() == $(document).height()){
                        app.loadMoreProducts();
                    }
                });
            }
        });
    }
})();