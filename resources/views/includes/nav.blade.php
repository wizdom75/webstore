<?php $categories = \App\models\Category::with('subCategories')->get()?>
<header class="navigation">
        <div class="title-bar toggle" data-responsive-toggle="main-menu" data-hide-for="medium">

            <div class="title-bar-left logo-text">
                {{-- <a href="{{ getenv('APP_URL') }}" class="small-logo"></a> --}}
                <a href="{{ getenv('APP_URL') }}" >{{ strtoupper(getenv('APP_NAME')) }}</a>
            </div>
            <div class="title-bar-right">
                <button class="menu-icon" type="button" data-toggle="main-menu"></button>
                <div class="title-bar-title"></div>
            </div>


        </div>

        <div class="top-bar" id="main-menu">

                <div class="top-bar-title show-for-medium logo-text">
                    {{-- <a href="{{ getenv('APP_URL') }}" class="logo"></a> --}}
                    <a href="{{ getenv('APP_URL') }}" >{{ strtoupper(getenv('APP_NAME')) }}</a>
                </div>

                    <div class="top-bar-left menu medium-horizontal expanded medium-text-center"
                         data-responsive-menu="drilldown medium-dropdown" data-click-open="true"
                         data-disable-hover="true" data-close-on-click-inside="false">
                    <ul class="dropdown menu vertical medium-horizontal">


                        @if(count($categories))

                            <li>
                                <a href="#">Categories</a>
                                <ul class="menu vertical sub dropdown">

                                    @foreach($categories as $category)
                                        <li>
                                            <a href="{{ getenv('APP_URL') }}/category/{{ $category->slug }}">{{ $category->name }}</a>
                                           <!-- @if(count($category->subCategories))

                                                <ul class="menu sub vertical">
                                                    @foreach($category->subCategories as $subCategory)
                                                        <li>
                                                            <a href="{{ getenv('APP_URL') }}/product/subcategory/{{ $subCategory->slug }}">{{ $subCategory->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif -->
                                        </li>
                                    @endforeach
                                </ul>
                            </li>

                        @endif
                    </ul>
                </div>


                <div class="top-bar-right">
                    <ul class="menu vertical medium-horizontal">
                        @if(isAuthenticated())
                            <li><a href="#">{{ user()->username }}</a> </li>
                            <li><a href="{{ getenv('APP_URL') }}/logout">Logout</a> </li>
                            <li>
                                <a href="{{ getenv('APP_URL') }}/cart">
                                    Cart &nbsp; <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                </a>
                            </li>

                        @else
                            <li><a href="{{ getenv('APP_URL') }}/login">Login</a> </li>
                            <li><a href="{{ getenv('APP_URL') }}/register">Register</a> </li>
                           <li>
                                <a href="{{ getenv('APP_URL') }}/cart">
                                    Cart &nbsp; <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                </a>
                            </li>
                        @endif

                    </ul>
                </div>


        </div>

</header>