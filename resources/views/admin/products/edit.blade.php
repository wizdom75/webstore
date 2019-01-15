@extends('admin.layout.base')

@section('title', 'Edit Product')

@section('data-page-id', 'adminProduct')

@section('content')

    <div class="add-product">


        <div class="row expanded">
            <h2>Edit {{ $product->name }}</h2> <hr/>
        </div>
        @include('includes.message')

        <form method="post" action="{{ getenv('APP_URL') }}/admin/product/edit" enctype="multipart/form-data">

            <div class="small-12 medium-11" style="padding-left: 1rem">

                <div class="row expanded grid-x grid-margin-x">

                    <div class="small-12 medium-6 column">
                        <label>Product name:
                            <input type="text" name="name"
                                   value="{{ $product->name }}">
                        </label>

                    </div>

                    <div class="small-12 medium-6 column">
                        <label>Product price:
                            <input type="text" name="price"
                                   value="{{ $product->price }}">
                        </label>

                    </div>

                    <div class="small-12 medium-6 column">
                        <label>Product category:
                            <select name="category" id="product-category">
                                <option value="{{ $product->category->id }}">

                                    {{ $product->category->name }}

                                </option>

                                @foreach($categories as $category)

                                    <option value="{{ $category->id }}">{{ $category->name }}</option>

                                @endforeach
                            </select>
                        </label>

                    </div>

                    <div class="small-12 medium-6 column">
                        <label>Product subcategory:
                            <select name="subcategory" id="product-subcategory">
                                <option value="{{ $product->subCategory->id }}">

                                    {{ $product->subCategory->name }}

                                </option>
                            </select>
                        </label>

                    </div>

                    <div class="small-12 medium-6 column">
                        <label>Product quantity:
                            <select name="quantity">
                                <option value="{{ $product->quantity }}">

                                    {{ $product->quantity }}

                                </option>

                                @for($i = 1; $i <= 50; $i++)

                                    <option value="{{ $i }}">{{ $i }}</option>

                                @endfor
                            </select>
                        </label>

                    </div>

                    <div class="small-12 medium-6 column">
                        <br/>
                        <div class="input-group">
                            <span class="input-group-label">Product image:</span>
                            <input type="file" name="productImage" class="input-group-field">
                        </div>

                    </div>

                    <div class="small-12 medium-6 column">
                        <label>Description:
                            <textarea rows="5" name="description" placeholder="Description">{{ $product->description }}</textarea>
                        </label>

                        <input type="hidden" name="token" value="{{ \App\classes\CSRFToken::_token() }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <button class="button warning float-right" type="submit">Update product</button>



                    </div>
                </div>
            </div>

        </form>

        <!--Delete button-->
        <div class="row expanded">
            <div class="small-12 medium-11">
                <table data-form="deleteForm">
                    <tr style="border: 1px solid #ffffff !important;">
                        <td style="border: 1px solid #ffffff !important;">
                            <form method="post" action="{{ getenv('APP_URL') }}/admin/product/{{$product->id}}/delete"
                                  class="delete-item">
                                <input type="hidden" name="token" value="{{ \App\classes\CSRFToken::_token() }}">
                                <button type="submit" class="button alert">Delete product</button>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


    @include('includes.delete-modal')

@endsection