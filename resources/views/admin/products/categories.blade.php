@extends('admin.layout.base')

@section('title', 'Product Category')

@section('data-page-id', 'adminCategories')

@section('content')

    <div class="category admin_shared">

        <div class="row expanded">

            <div class="column medium-11">
                <h2>Product Categories</h2>
            </div>
        </div>
        @include('includes.message')

        <div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-4">
            &nbsp;
            &nbsp;
            &nbsp;
            <div class="small-12 medium-6 column">
                <form action="{{ getenv('APP_URL') }}/admin/" method="post">
                    <div class="input-group">
                        <input type="text" class="input-group-field" placeholder="Search by name">
                        <div class="input-group-button">
                            <input type="submit" class="button" value="Search">
                        </div>
                    </div>
                </form>
            </div>
            &nbsp;
            &nbsp;
            &nbsp;

            <div class="small-12 medium-5 end column">
                <form action="{{ getenv('APP_URL') }}/admin/product/categories" method="post">
                    <div class="input-group">
                        <input name="name" type="text" class="input-group-field" placeholder="Category name">
                        <input type="hidden" name="token" value="{{ \App\classes\CSRFToken::_token() }}">
                        <div class="input-group-button">
                            <input type="submit" class="button" value="Create">
                        </div>
                    </div>

                </form>

            </div>

        </div>
        <div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-4">
            &nbsp;
            &nbsp;
            &nbsp;
            <div class="small-12 medium-11 column">

                @if(count($categories))
                    <table class="hover unstriped" data-form="deleteForm">
                       <tr>
                           <thead>
                           <th>Name</th>
                           <th>Slug</th>
                           <th>Date created</th>
                           <th width="80">Action</th>
                           </thead>
                       </tr>

                        @foreach($categories as $category)

                            <tr>
                                <td>{{ $category['name'] }}</td>
                                <td>{{ $category['slug'] }}</td>
                                <td>{{ $category['added'] }}</td>
                                <td width="60" class="text-right">

                                    <span data-tooltip tabindex="1" title="Click here to add a subcategory">
                                        <a data-open="add-subcategory-{{ $category['id'] }}"><i class="fa fa-plus"></i> </a>
                                    </span>
                                    <span data-tooltip tabindex="1" title="Click here to edit category">
                                        <a data-open="item-{{ $category['id'] }}"><i class="fa fa-edit"></i> </a>
                                    </span>
                                    <span style="display: inline-block" data-tooltip tabindex="1" title="Click here to delete category">
                                        <form method="post" action="{{ getenv('APP_URL') }}/admin/product/categories/{{$category['id']}}/delete"
                                              class="delete-item">
                                            <input type="hidden" name="token" value="{{ \App\classes\CSRFToken::_token() }}">
                                            <button type="submit"><i class="fa fa-times delete"></i> </button>
                                        </form>
                                    </span>


                                    <!-- Edit category modal-->

                                    <div class="reveal" id="item-{{ $category['id'] }}"
                                         data-reveal data-close-on-click="false" data-close-on-esc="false"
                                    data-animation-in="scale-in-up" data-animation-out="scale-out-down">
                                        <div class="notification callout primary"></div>
                                        <h2>Edit category</h2>
                                        <form>
                                            <div class="input-group">
                                                <input name="name" id="item-name-{{ $category['id'] }}"
                                                       type="text" value="{{ $category['name'] }}">
                                                <div>
                                                    <input type="submit" class="button update-category"
                                                           id="{{ $category['id'] }}"
                                                           data-token="{{ \App\classes\CSRFToken::_token() }}"
                                                           value="Update">
                                                </div>
                                            </div>

                                        </form>

                                        <a href="{{ getenv('APP_URL') }}/admin/product/categories" class="close-button" data-close aria-label="Close modal" type="button">
                                            <span aria-hidden="true">&times;</span>
                                        </a>
                                    </div>
                                    <!-- End category modal-->


                                    <!-- Add subcategory modal-->

                                    <div class="reveal" id="add-subcategory-{{ $category['id'] }}"
                                         data-reveal data-close-on-click="false" data-close-on-esc="false"
                                         data-animation-in="scale-in-up" data-animation-out="scale-out-down">
                                        <div class="notification callout primary"></div>
                                        <h2>Add subcategory</h2>
                                        <form>
                                            <div class="input-group">
                                                <input id="subcategory-name-{{ $category['id'] }}" type="text">
                                                <div>
                                                    <input type="submit" class="button add-subcategory"
                                                           id="{{ $category['id'] }}"
                                                           data-token="{{ \App\classes\CSRFToken::_token() }}"
                                                           value="Create">
                                                </div>
                                            </div>

                                        </form>

                                        <a href="{{ getenv('APP_URL') }}/admin/product/categories" class="close-button" data-close aria-label="Close modal" type="button">
                                            <span aria-hidden="true">&times;</span>
                                        </a>
                                    </div>

                                    <!-- End subcategory modal-->

                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                    {!! $links !!}
                @else
                    <h3>You have not created any categories</h3>
                @endif

            </div>
        </div>

    </div>



    <div class="subcategory admin_shared">

        <div class="row expanded">
            <h2>Sub Categories</h2>
        </div>


        <div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-4">
            &nbsp;
            &nbsp;
            &nbsp;
            <div class="small-12 medium-11 column">

                @if(count($subcategories))
                    <table class="hover unstriped" data-form="deleteForm">
                        <tr>
                            <thead>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Date created</th>
                            <th width="50">Action</th>
                            </thead>
                        </tr>
                        <tbody>
                        @foreach($subcategories as $subcategory)

                            <tr>
                                <td>{{ $subcategory['name'] }}</td>
                                <td>{{ $subcategory['slug'] }}</td>
                                <td>{{ $subcategory['added'] }}</td>
                                <td width="50" class="text-right">

                                    <span data-tooltip tabindex="1" title="Click here to edit subcategory">
                                        <a data-open="item-subcategory-{{ $subcategory['id'] }}"><i class="fa fa-edit"></i> </a>
                                    </span>
                                    <span style="display: inline-block" data-tooltip tabindex="1" title="Click here to delete subcategory">
                                        <form method="post" action="{{ getenv('APP_URL') }}/admin/product/subcategory/{{$subcategory['id']}}/delete"
                                              class="delete-item">
                                            <input type="hidden" name="token" value="{{ \App\classes\CSRFToken::_token() }}">
                                            <button type="submit"><i class="fa fa-times delete"></i> </button>
                                        </form>
                                    </span>


                                    <!-- Edit subcategory modal-->

                                    <div class="reveal" id="item-subcategory-{{ $subcategory['id'] }}"
                                         data-reveal data-close-on-click="false" data-close-on-esc="false"
                                         data-animation-in="scale-in-up" data-animation-out="scale-out-down">
                                        <div class="notification callout primary"></div>
                                        <h2>Edit subcategory</h2>
                                        <form>
                                            <div class="input-group">
                                                <input id="item-subcategory-name-{{ $subcategory['id'] }}"
                                                       type="text" value="{{ $subcategory['name'] }}">

                                                <label>Change Category
                                                    <select id="item-category-{{ $subcategory['category_id'] }}">
                                                        @foreach(\App\models\Category::all() as $category)

                                                            @if($category->id == $subcategory['category_id'])

                                                                <option selected="selected" value="{{ $category->id }}">{{ $category->name }}</option>

                                                            @endif

                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach

                                                    </select>

                                                </label>
                                                <div>
                                                    <input type="submit" class="button update-subcategory"
                                                           id="{{ $subcategory['id'] }}"
                                                           data-category-id="{{ $subcategory['category_id'] }}"
                                                           data-token="{{ \App\classes\CSRFToken::_token() }}"
                                                           value="Update">
                                                </div>
                                            </div>

                                        </form>

                                        <a href="{{ getenv('APP_URL') }}/admin/product/categories" class="close-button" data-close aria-label="Close modal" type="button">
                                            <span aria-hidden="true">&times;</span>
                                        </a>
                                    </div>
                                    <!-- End subcategory modal-->


                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                    {!! $subcategories_links !!}
                @else
                    <h2>You have not created any categories</h2>
                @endif

            </div>
        </div>

    </div>

    @include('includes.delete-modal')

@endsection