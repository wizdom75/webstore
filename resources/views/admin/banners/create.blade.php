@extends('admin.layout.base')

@section('title', 'Create Banner')

@section('data-page-id', 'adminBanner')

@section('content')

    <div class="add-product admin_shared">

        <div class="row expanded">
            <h2>Add a banner</h2> <hr/>
        </div>
        @include('includes.message')

        <form method="post" action="{{ getenv('APP_URL') }}/admin/banner/create" enctype="multipart/form-data">

            <div class="small-12 medium-11" style="padding-left: 1rem;">
                <div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-4">
                    <div class="small-12 medium-11 column">
                        <label>Banner title:
                            <input type="text" name="title" placeholder=" Banner title"
                                   value="{{ \App\classes\Request::old('post', 'title') }}">
                        </label>

                    </div>
                    <div class="small-12 medium-11 column">
                        <label>Banner link:
                            <input type="text" name="link_url" placeholder=" Banner link"
                                   value="{{ \App\classes\Request::old('post', 'link_url') }}">
                        </label>

                    </div>

                    <div class="small-12 medium-6 column">
                        <br/>
                        <div class="input-group">
                            <span class="input-group-label">Banner image:</span>
                            <input type="file" name="banner_image" class="input-group-field">
                        </div>

                    </div>

                    <div class="small-12 medium-11 column">


                        <input type="hidden" name="token" value="{{ \App\classes\CSRFToken::_token() }}">
                        <button class="button alert" type="reset">Reset</button>

                        <button class="button success float-right" type="submit">Save banner</button>



                    </div>
                </div>
            </div>

        </form>
    </div>


    @include('includes.delete-modal')

@endsection