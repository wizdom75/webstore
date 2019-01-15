(function () {

    'use strict';

    $(document).foundation();


    $(document).ready(function(){

        //switch pages
        switch ($("body").data("page-id")){

            case 'home':
                WEBSTORE.homeslider.initCarousel();
                WEBSTORE.homeslider.homePageProducts();
                break;

            case 'product':
                WEBSTORE.product.details();
                break;

            case 'page':
                WEBSTORE.page.details();
                break;

            case 'category':
                WEBSTORE.category.products();
                break;

            case 'subcategory':
                WEBSTORE.subcategory.products();
                break;

            case 'cart':
                WEBSTORE.product.cart();
                break;

            case 'adminProduct':
                WEBSTORE.admin.changeEvent();
                WEBSTORE.admin.delete();

                break;

            case 'adminDashboard':
                WEBSTORE.admin.dashboard();
                break;

            case 'adminCategories':
                WEBSTORE.admin.update();
                WEBSTORE.admin.delete();
                WEBSTORE.admin.create();
                break;

            default:
                WEBSTORE.message.send();
        }
    })

})();