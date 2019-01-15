@extends('admin.layout.base')

@section('title', 'Pages')

@section('data-page-id', 'adminPages')

@section('content')

    <div class="messages admin_shared">

        <div class="row expanded">

            <div class="column medium-11">
                <h2>Pages</h2>
            </div>
        </div>
        @include('includes.message')

        <div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-4">
            &nbsp;
            &nbsp;
            &nbsp;
            <div class="small-12 medium-11 column">

                @if(count($pages))
                    <table class="hover unstriped" data-form="deleteForm">
                       <tr>
                           <thead>
                           <th>Title</th>
                           <th>Snippet</th>
                           <th width="80">Action</th>
                           </thead>
                       </tr>

                        @foreach($pages as $page)

                            <tr>
                                <td>{{ $page['title'] }}</td>
                                <td>{{ substr($page['body'], 0, 70) }}.......</td>
                                <td width="60" class="text-center">

                                    <span data-tooltip tabindex="1" title="Edit">

                                        <a data-open="item-{{ $page['id'] }}"><i class="fa fa-pencil-square-o "></i> </a>

                                    </span>
                                    <!--
                                    <span style="display: inline-block" data-tooltip tabindex="1" title="Delete page">
                                        <form method="post" action="{{ getenv('APP_URL') }}/admin/page/{{$page['id']}}/delete"
                                              class="delete-item">
                                            <input type="hidden" name="token" value="{{ \App\classes\CSRFToken::_token() }}">
                                            <button type="submit"><i class="fa fa-times delete"></i> </button>
                                        </form>
                                    </span>


                                    <!-- Action messages modal-->

                                    <div class="reveal" id="item-{{ $page['id'] }}"
                                         data-reveal data-close-on-click="false" data-close-on-esc="false"
                                    data-animation-in="scale-in-up" data-animation-out="scale-out-down">
                                        <div class="notification callout primary"></div>
                                        <form>
                                            <div class="grid-container">
                                                <div class="grid-x grid-padding-x">
                                                    <div class="medium-12 cell">
                                                        <label><b>Title:</b>
                                                            <input name="title" type="text" value="{{ $page['title'] }}">
                                                            <input type="hidden" name="id" value="{{ $page['id'] }}">
                                                        </label>
                                                    </div>
                                                    <div class="medium-12 cell">
                                                        <label><b>Main writeup:</b>
                                                            <textarea name="body" cols="60" rows="10">{{ $page['body'] }}</textarea>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="medium-12 cell">
                                                    <button class="button warning float-left" type="submit">Update page</button>
                                                </div>
                                                <input type="hidden" name="token" value="{{ \App\classes\CSRFToken::_token() }}">
                                            </div>
                                        </form>



                                        <a href="{{ getenv('APP_URL') }}/admin/pages" class="close-button" data-close aria-label="Close modal" type="button">
                                            <span aria-hidden="true">&times;</span>
                                        </a>
                                    </div>


                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                    {!! $links !!}
                @else
                    <h3>You have no pages yet</h3>
                @endif

            </div>
        </div>

    </div>

    @include('includes.delete-modal')

@endsection