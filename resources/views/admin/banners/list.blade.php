@extends('admin.layout.base')

@section('title', 'Manage Banners')

@section('data-page-id', 'adminBanners')

@section('content')

    <div class="banners admin_shared">

        <div class="row expanded">
            <div class="column medium-11">
                <h2>Manage banners</h2><hr/>
            </div>

        </div>


        @include('includes.message')

        <div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-4">
            &nbsp;
            &nbsp;
            &nbsp;
            <div class="small-12 medium-6 column">

                <div class="small-12 medium-11 column">
                    <a href="{{ getenv('APP_URL') }}/admin/banner/create" class="button float-right">
                        <i class="fa fa-plus" >Add new banner</i>
                    </a>
                </div>

                @if(count($banners))
                    <table class="hover unstriped" data-form="deleteForm">
                       <tr>
                           <thead>
                           <th>Title</th>
                           <th>Link</th>
                           <th>Image</th>
                           <th width="80">Action</th>
                           </thead>
                       </tr>

                        @foreach($banners as $banner)

                            <tr>

                                <td>{{ $banner['title'] }}</td>
                                <td>{{ $banner['link_url'] }}</td>
                                <td>{{ $banner['image_url'] }}</td>

                                <td width="60" class="text-right">

                                    <span data-tooltip tabindex="1" title="Edit user">
                                        <a href="{{ getenv('APP_URL') }}/admin/banner/{{$banner['id']}}/edit">Edit <i class="fa fa-edit"></i> </a>
                                    </span>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                    {!! $links !!}
                @else
                    <h3>You have not created any banners</h3>
                @endif

            </div>
        </div>

    </div>


@endsection