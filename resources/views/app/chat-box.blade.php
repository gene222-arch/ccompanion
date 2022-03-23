@extends('layouts.main')

@section('css')
    <style>
        .chat-container {
            height: 70vh; 
            overflow-y: scroll; 
            scroll-snap-type: y proximity; 
            overscroll-behavior-y: contain;
        }
        .chat-container > div:last-child {
            scroll-snap-align: end;
        }

    </style>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-10 chat-container">
            <div class="card" style="">
                <div class="card-header bg-primary text-white">Tell us your concern.</div>
                <div class="card-body messages">
                    <div class="row">
                        <div class="col-6 my-4">
                            <div style="width: auto;">
                                <div class="row align-items-center">
                                    <div class="col-1">
                                        <span class="badge rounded-pill bg-dark p-2">
                                            <span class="fa-1x">G</span>
                                        </span>
                                    </div>
                                    <div class="col-11">
                                        <div class="border border-dark rounded p-2">
                                            Lorem, ipsum dolor sit amet consecte
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9] as $s)
                            <div class="col-12"></div>
                            <div class="col-6 my-4" style="margin-left: auto;">
                                <div class="row align-items-center">
                                    <div class="col-11">
                                        <div class="border border-dark rounded p-2">
                                            Lorem, ipsum dolor sit amet consecte
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <span class="badge rounded-pill bg-dark p-2">
                                            <span class="fa-1x">S</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-10">
            <div class="chat-box mt-2">
                <form action="" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input 
                            type="text" 
                            class="form-control @error('message') is-invalid @enderror" 
                            placeholder="Type a message..."
                            aria-describedby="button-addon2"
                            name="message"
                            style="border-radius: 7rem;"
                        >
                        @error('message')
                            {{ $message }}
                        @enderror
                        <button class="btn border-white" type="button" id="button-addon2">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        Echo.private('new.chat.message.event')
            .listen('NewChatMessageEvent', e => {
                console.log(e)
            });
    </script>
@endsection