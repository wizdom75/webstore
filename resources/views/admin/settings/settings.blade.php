@extends('admin.layout.base')

@section('title', 'Settings')

@section('data-page-id', 'adminSettings')

@section('content')

    <div class="settings admin_shared">

        <div class="row expanded">

            <div class="column medium-11">
                <h2>Settings</h2>
            </div>
        </div>
        @include('includes.message')

        <div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-4">
            &nbsp;
            &nbsp;<form method="post" action="/admin/settings/update">
                <div class="grid-container">
                    <div class="grid-x grid-padding-x">



                            @foreach($settings as $setting)
                        <div class="medium-12 cell">
                            <label>Contact number:
                                <input name="telephone" type="text" value="{{ $setting['telephone'] }}">
                                <input type="hidden" name="id" value="{{ $setting['id'] }}">
                            </label>
                        </div>
                        <div class="medium-6 cell">
                            <label>Address:
                                <textarea cols="70" rows="5" name="address">{{ $setting['address'] }}</textarea>
                            </label>
                        </div>
                            @endforeach


                    </div>
                    <div class="medium-12 cell">
                        <button class="button warning float-left" type="submit">Update settings</button>
                    </div>
                </div>
                <input type="hidden" name="token" value="{{ \App\classes\CSRFToken::_token() }}">
            </form>

        </div>

    </div>


@endsection