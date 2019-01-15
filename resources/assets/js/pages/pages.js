(function () {
    'use strict';
    
    WEBSTORE.page.details = function () {
        var app = new Vue({
            el: '#page',
            data:{
                page: [],
                slug: $('#page').data('id'),
                loading: false
            },
            methods:{
                getPageDetails: function () {
                    this.loading = true;
                    setTimeout(function () {
                        axios.get('/page-details/' + app.slug).then(
                            function (response) {
                                app.page = response.data.page;
                                app.loading = false;
                            });
                    }, 1000);
                }
            },
            created: function () {
                this.getPageDetails();
            }
        });
    }
})();