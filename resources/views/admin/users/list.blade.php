@extends('admin.layout.base')

@section('title', 'Manage Users')

@section('data-page-id', 'adminUsers')

@section('content')

    <div class="users admin_shared">

        <div class="row expanded">
            <div class="column medium-11">
                <h2>Manage users</h2><hr/>
            </div>

        </div>


        @include('includes.message')

        <div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-4">
            &nbsp;
            &nbsp;
            &nbsp;
            <div class="small-12 medium-6 column">

                @if(count($users))
                    <table class="hover unstriped" data-form="deleteForm">
                       <tr>
                           <thead>
                           <th>Username</th>
                           <th>Fullname</th>
                           <th>Email</th>
                           <th>Address</th>
                           <th>Role</th>
                           <th>Date created</th>
                           <th width="80">Action</th>
                           </thead>
                       </tr>

                        @foreach($users as $product)

                            <tr>

                                <td>{{ $product['username'] }}</td>
                                <td>{{ $product['fullname'] }}</td>
                                <td>{{ $product['email'] }}</td>
                                <td>{{ $product['address'] }}</td>
                                <td>{{ $product['role'] }}</td>
                                <td>{{ $product['added'] }}</td>

                                <td width="60" class="text-right">

                                    <span data-tooltip tabindex="1" title="Edit user">
                                        <a href="{{ getenv('APP_URL') }}/admin/user/{{ $product['id'] }}/edit">Edit <i class="fa fa-edit"></i> </a>
                                    </span>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                    {!! $links !!}
                @else
                    <h3>You have not created any users</h3>
                @endif

            </div>
        </div>

    </div>


@endsection