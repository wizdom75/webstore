(function(){
    'use strict'

    WEBSTORE.category.products = function () {
        var app = new Vue({

            el: '#category',
            data: {
                products: [],
                subcategories: [],
                slug: $('#category').data('id'),
                count: 0,
                loading: false
            },
            methods:{
                getSubcategories: function(){
                    this.loading = true;
                    setTimeout(function () {
                    axios.all(
                        [
                            axios.get('/get-subcategory/' + app.slug),
                            axios.get('/get-category-products/' + app.slug)
                        ]
                    ).then(axios.spread(function (subCatResponse, productResponse) {
                        app.subcategories = subCatResponse.data.subcategories;
                        app.products = productResponse.data.products;
                        app.loading = false;


                    }));

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
                    axios.post('/load-more-category-products/' + app.slug, data)
                        .then(function (response) {
                            app.products = response.data.products;
                            app.count = response.data.count;
                            app.loading = false;
                        });
                }

            },
            created: function () {
                this.getSubcategories();
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

