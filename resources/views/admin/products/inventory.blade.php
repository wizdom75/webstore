@extends('admin.layout.base')

@section('title', 'Manage Inventory')

@section('data-page-id', 'adminProduct')

@section('content')

    <div class="products admin_shared">

        <div class="row expanded">
            <div class="column medium-11">
                <h2>Manage Inventory Items</h2><hr/>
            </div>

        </div>


        @include('includes.message')

        <div class="row expanded">
            <div class="small-12 medium-11 column">
                <a href="{{ getenv('APP_URL') }}/admin/product/create" class="button float-right">
                    <i class="fa fa-plus" >Add new product</i>
                </a>
            </div>
        </div>
        <div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-4">
            &nbsp;
            &nbsp;
            &nbsp;
            <div class="small-12 medium-11 column">

                @if(count($products))
                    <table class="hover unstriped" data-form="deleteForm">
                       <tr>
                           <thead>
                           <th>Image</th>
                           <th>Name</th>
                           <th>Price</th>
                           <th>Quantity</th>
                           <th>Category</th>
                           <th>Sub Category</th>
                           <th>Date created</th>
                           <th width="80">Action</th>
                           </thead>
                       </tr>

                        @foreach($products as $product)

                            <tr>
                                <td>
                                    <img src="{{ getenv('APP_URL') }}/{{ $product['image_path'] }}"
                                    alt="{{ $product['name'] }} " height="40" width="40">
                                </td>
                                <td>{{ $product['name'] }}</td>
                                <td>{{ $product['price'] }}</td>
                                <td>{{ $product['quantity'] }}</td>
                                <td>{{ $product['category_name'] }}</td>
                                <td>{{ $product['sub_category_name'] }}</td>
                                <td>{{ $product['added'] }}</td>

                                <td width="60" class="text-right">

                                    <span data-tooltip tabindex="1" title="Edit product">
                                        <a href="{{ getenv('APP_URL') }}/admin/product/{{ $product['id'] }}/edit">Edit <i class="fa fa-edit"></i> </a>
                                    </span>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                    {!! $links !!}
                @else
                    <h3>You have not created any products</h3>
                @endif

            </div>
        </div>

    </div>


@endsection