@extends('admin.layout.base')

@section('title', 'Create Product')

@section('data-page-id', 'adminProduct')

@section('content')

    <div class="add-product admin_shared">

        <div class="row expanded">
            <h2>Add inventory items</h2> <hr/>
        </div>
        @include('includes.message')

        <form method="post" action="{{ getenv('APP_URL') }}/admin/product/create" enctype="multipart/form-data">

            <div class="small-12 medium-11" style="padding-left: 1rem;">
                <div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-4">
                    <div class="small-12 medium-6 column">
                        <label>Product name:
                            <input type="text" name="name" placeholder=" Product name"
                                   value="{{ \App\classes\Request::old('post', 'name') }}">
                        </label>

                    </div>
                    <div class="small-12 medium-6 column">
                        <label>Product price:
                            <input type="text" name="price" placeholder=" Product price"
                                   value="{{ \App\classes\Request::old('post', 'price') }}">
                        </label>

                    </div>
                    <div class="small-12 medium-6 column">
                        <label>Product category:
                            <select name="category" id="product-category">
                                <option value="{{ \App\classes\Request::old('post', 'category')?:'' }}">

                                    {{ \App\classes\Request::old('post', 'category')?:'Select category' }}

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
                                <option value="{{ \App\classes\Request::old('post', 'subcategory')?:'' }}">

                                    {{ \App\classes\Request::old('post', 'subcategory')?:'Select subcategory' }}

                                </option>
                            </select>
                        </label>

                    </div>


                    <div class="small-12 medium-6 column">
                        <label>Product quantity:
                            <select name="quantity">
                                <option value="{{ \App\classes\Request::old('post', 'quantity')?:'' }}">

                                    {{ \App\classes\Request::old('post', 'quantity')?:'Select quantity' }}

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
                            <textarea name="description" placeholder="Description">{{ \App\classes\Request::old('post', 'description') }}</textarea>
                        </label>

                        <input type="hidden" name="token" value="{{ \App\classes\CSRFToken::_token() }}">
                        <button class="button alert" type="reset">Reset</button>

                        <button class="button success float-right" type="submit">Save product</button>



                    </div>
                </div>
            </div>

        </form>
    </div>


    @include('includes.delete-modal')

@endsection