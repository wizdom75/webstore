@extends('admin.layout.base')

@section('title', 'Edit Product')

@section('data-page-id', 'adminProduct')

@section('content')

    <div class="add-product">


        <div class="row expanded">
            <h2>Edit {{ $banner->title }}</h2> <hr/>
        </div>
        @include('includes.message')

        <form method="post" action="{{ getenv('APP_URL') }}/admin/banner/edit" enctype="multipart/form-data">

            <div class="small-12 medium-11" style="padding-left: 1rem">

                <div class="row expanded grid-x grid-margin-x">

                    <div class="small-12 medium-6 column">
                        <label>Banner title:
                            <input type="text" name="name"
                                   value="{{ $banner->title }}">
                        </label>

                    </div>

                    <div class="small-12 medium-6 column">
                        <label>Banner link:
                            <input type="text" name="price"
                                   value="{{ $banner->link_url }}">
                        </label>

                    </div>

                    <div class="small-12 medium-11 column">
                        <label>Banner link:
                            <div class="image-holder">
                                <img src="{{ getenv('APP_URL') }}/images/users/1.jpeg" alt="" title="Admin">
                                <p>{{ user()->fullname }}</p>
                            </div>
                        </label>

                    </div>

                    <div class="small-12 medium-11 column">
                            <br/>
                            <div class="input-group">
                                <span class="input-group-label">Banner image:</span>
                                <input type="file" name="banner_image" class="input-group-field">
                            </div>
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
                            <form method="post" action="{{ getenv('APP_URL') }}/admin/banner/{{$banner->id}}/delete"
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