<!-- Sidebar Menu -->

<div class="off-canvas position-left reveal-for-large nav" id="offCanvas" data-off-canvas>


    <h3>Admin panel</h3>
    <div class="image-holder text-center">
        <img src="{{ getenv('APP_URL') }}/images/users/1.jpeg" alt="" title="Admin">
        <p>{{ user()->fullname }}</p>
    </div>


    <ul class="vertical menu">
        <li><a href="{{ getenv('APP_URL') }}/admin"><i class="fa fa-tachometer fa-fw" aria-hidden="true"></i>&nbsp; Dashboard</a></li>
        <li><a href="{{ getenv('APP_URL') }}/admin/product/categories"><i class="fa fa-compress fa-fw" aria-hidden="true"></i>&nbsp; Categories</a></li>
        <li><a href="{{ getenv('APP_URL') }}/admin/products"><i class="fa fa-pencil-square-o fa-fw" aria-hidden="true"></i>&nbsp; Products</a></li>
        <li><a href="{{ getenv('APP_URL') }}/admin/messages"><i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i>&nbsp; Messages</a></li>
        <li><a href="{{ getenv('APP_URL') }}/admin/users"><i class="fa fa-users fa-fw" aria-hidden="true"></i>&nbsp; Users</a></li>
        <li><a href="{{ getenv('APP_URL') }}/admin/pages"><i class="fa fa-file-o fa-fw" aria-hidden="true"></i>&nbsp; Pages</a></li>
        <li><a href="{{ getenv('APP_URL') }}/admin/banners"><i class="fa fa-picture-o fa-fw" aria-hidden="true"></i>&nbsp; Banners</a></li>
        <li><a href="{{ getenv('APP_URL') }}/admin/settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i>&nbsp; Settings</a></li>


       <!-- <li><a href="{{ getenv('APP_URL') }}/admin/users/orders"><i class="fa fa-shopping-cart fa-fw" aria-hidden="true"></i>&nbsp; View Orders</a></li>
        <li><a href="{{ getenv('APP_URL') }}/admin/users/payments"><i class="fa fa-money fa-fw" aria-hidden="true"></i>&nbsp; Payments</a></li>-->
        <li><a href="{{ getenv('APP_URL') }}/logout"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i>&nbsp; Logout</a></li>
    </ul>


</div>

<!-- End of Sidebar Menu -->