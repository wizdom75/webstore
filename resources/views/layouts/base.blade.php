<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <title>Webstore - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale-1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.4.3/css/foundation.min.css" />
    <script src="https://use.fontawesome.com/b8eb7852c5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link rel="stylesheet" href="{{ getenv('APP_URL') }}/css/all.css">

</head>

<body data-page-id="@yield('data-page-id')">

@yield('body')


<script src="{{ getenv('APP_URL') }}/js/all.js"></script>

@yield('stripe-checkout')

</body>
</html>