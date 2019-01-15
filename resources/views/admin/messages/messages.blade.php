@extends('admin.layout.base')

@section('title', 'Messages')

@section('data-page-id', 'adminMessages')

@section('content')

    <div class="messages admin_shared">

        <div class="row expanded">

            <div class="column medium-11">
                <h2>Messages</h2>
            </div>
        </div>
        @include('includes.message')

        <div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-4">
            &nbsp;
            &nbsp;
            &nbsp;
            <div class="small-12 medium-11 column">

                @if(count($messages))
                    <table class="hover unstriped" data-form="deleteForm">
                       <tr>
                           <thead>
                           <th>From</th>
                           <th>Email</th>
                           <th>Date received</th>
                           <th width="80">Action</th>
                           </thead>
                       </tr>

                        @foreach($messages as $message)

                            <tr>
                                <td>{{ $message['sender_name'] }}</td>
                                <td>{{ $message['sender_email'] }}</td>
                                <td>{{ $message['created_at'] }}</td>
                                <td width="60" class="text-right">

                                    <span data-tooltip tabindex="1" title="Read message">
                                        @if($message['message_read'] > 0)
                                        <a data-open="item-{{ $message['id'] }}"><i class="fa fa-envelope-open-o"></i> </a>
                                        @else
                                        <a data-open="item-{{ $message['id'] }}"><i class="fa fa-envelope-o"></i> </a>
                                        @endif
                                    </span>
                                    <span style="display: inline-block" data-tooltip tabindex="1" title="Delete message">
                                        <form method="post" action="{{ getenv('APP_URL') }}/admin/message/{{$message['id']}}/delete"
                                              class="delete-item">
                                            <input type="hidden" name="token" value="{{ \App\classes\CSRFToken::_token() }}">
                                            <button type="submit"><i class="fa fa-times delete"></i> </button>
                                        </form>
                                    </span>


                                    <!-- Action messages modal-->

                                    <div class="reveal" id="item-{{ $message['id'] }}"
                                         data-reveal data-close-on-click="false" data-close-on-esc="false"
                                    data-animation-in="scale-in-up" data-animation-out="scale-out-down">
                                        <div class="notification callout primary"></div>
                                        <b>From: {{ $message['sender_name'] }}</b>
                                        <p>{{{ $message['message'] }}}</p>



                                        <a href="{{ getenv('APP_URL') }}/admin/messages" class="close-button" data-close aria-label="Close modal" type="button">
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
                    <h3>You have no messages yet</h3>
                @endif

            </div>
        </div>

    </div>

    @include('includes.delete-modal')

@endsection