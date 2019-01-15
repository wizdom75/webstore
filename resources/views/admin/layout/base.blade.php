<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <title>Admin Panel - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale-1.0">



    <link rel="stylesheet" href="{{ getenv('APP_URL') }}/css/all.css">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://use.fontawesome.com/b8eb7852c5.js"></script>



</head>

<body data-page-id="@yield('data-page-id')">


@include('includes.admin-sidebar')



<div class="off-canvas-content admin_title_bar" data-off-canvas-content>
    <!-- Your page content lives here -->

    <div class="title-bar">
        <div class="title-bar-left">
            <button class="menu-icon hide-for-large" type="button" data-open="offCanvas"></button>
            <span class="title-bar-title">{{ getenv('APP_NAME') }}</span>
        </div>
    </div>
    @yield('content')
</div>




<script src="{{ getenv('APP_URL') }}/js/all.js"></script>

</body>
</html>