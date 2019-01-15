(function(){
    'use strict'

    WEBSTORE.subcategory.products = function () {
        var app = new Vue({

            el: '#subcategory',
            data: {
                products: [],
                slug: $('#subcategory').data('id'),
                count: 0,
                loading: false
            },
            methods:{
                getProducts: function(){
                    this.loading = true;
                    setTimeout(function () {
                        axios.get('/get-subcategory-products/' + app.slug).then(function (productResponse) {
                            app.products = productResponse.data.products;
                            app.loading = false;

                        });

                    }, 1000);
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
                    axios.post('/load-more-subcategory-products/' + app.slug, data)
                        .then(function (response) {
                            app.products = response.data.products;
                            app.count = response.data.count;
                            app.loading = false;
                        });
                }

            },
            created: function () {
                this.getProducts();
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

