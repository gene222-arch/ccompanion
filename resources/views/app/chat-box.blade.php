@extends('layouts.main')

@section('css')
    <style>
        .chat-container {
            height: 60vh; 
            overflow-y: scroll;
        }
        .delete-message-icon {
            cursor: pointer;
        }
        .delete-message-icon:hover {
            color: tomato;
        }
    </style>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="modal fade" id="deleteMessageConfirmationModal" tabindex="-1" aria-labelledby="deleteMessageConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteMessageConfirmationModalLabel">Delete selected message</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Continue?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary delete-message-btn">Save changes</button>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-10"><div class="card-header bg-primary text-white">Tell us your concern.</div></div>
        <div class="col-12 col-sm-12 col-md-12 chat-container">
            <div class="card">
                <div class="card-body messages">
                    <div class="row chat-rows">
                        @foreach ($chats as $chat)
                            @if ($chat->type === 'receiver')
                                <div class="col-7 my-4" id="chatID{{ $chat->id }}">
                                    <div style="width: auto;">
                                        <div class="row align-items-center">
                                            <div class="col-1">
                                                <span 
                                                    class="badge rounded-pill bg-dark p-2" style="cursor: pointer;"
                                                    data-toggle='tooltip'
                                                    data-placement='left'
                                                    title="{{ $chat->user->name }}"
                                                >
                                                    <span class="fa-1x">{{ Str::substr($chat->user->name, 0, 1) }}</span>
                                                </span>
                                            </div>
                                            <div class="col-11">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <div class="border border-dark rounded p-2" style="width: fit-content;">
                                                            {{ $chat->message }}
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        @if (Auth::user()->id === $chat->user_id)
                                                            <i 
                                                                class="fa-solid fa-trash delete-message-icon"
                                                                data-toggle='tooltip'
                                                                data-placement="right"
                                                                title='Remove'
                                                                value={{ $chat->id }}
                                                            ></i>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else 
                                <div class="col-7 my-4" style="margin-left: auto;" id="chatID{{ $chat->id }}">
                                    <div class="row align-items-center">
                                        <div class="col-11">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    @if (Auth::user()->id === $chat->user_id)
                                                        <i 
                                                            class="fa-solid fa-trash delete-message-icon"
                                                            data-toggle='tooltip'
                                                            data-placement="right"
                                                            title='Remove'
                                                            value={{ $chat->id }}
                                                        ></i>
                                                    @endif
                                                </div>
                                                <div class="col">
                                                    <div class="border border-dark rounded p-2" style="width: fit-content; margin-left: auto;">
                                                        {{ $chat->message }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <span 
                                                class="badge rounded-pill bg-dark p-2" 
                                                style="cursor: pointer;"
                                                data-toggle='tooltip'
                                                data-placement='right'
                                                title="{{ $chat->user->name }}"
                                            >
                                                <span class="fa-1x">
                                                    {{ Str::substr($chat->user->name, 0, 1) }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 mt-4">
            <form id="inputMessageForm">
                <div class="chat-box">
                    <div class="input-group mb-3">
                        <input 
                            type="text"
                            placeholder="Type a message..."
                            aria-describedby="button-addon2"
                            name="message"
                            style="border-radius: 7rem;"
                            class="form-control input-message"
                        >
                        <button type="submit" class="btn border-white submit-chat-btn" type="button" id="button-addon2">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const authUserID = {{ Auth::user()->id }};

        const addListenerToDeleteIcon = () => 
        {
            [ ...document.querySelectorAll('.delete-message-icon') ]
            .map(deleteIconElement => 
            {
                deleteIconElement
                    .addEventListener('click', function (e) 
                    {
                       const chatID = deleteIconElement.getAttribute('value');
                       console.log(chatID);
                       $('#deleteMessageConfirmationModal').modal('show');

                       $('.delete-message-btn').click(() => 
                       {
                            axios.delete(`/chats/${ chatID }`)
                                .then(res => {
                                    $(`#chatID${ chatID }`).hide();
                                    $('#deleteMessageConfirmationModal').modal('hide');
                                })
                                .catch(err => console.log(err));
                       })
                    })
            });
        };

        /** Instantiate listener */
        addListenerToDeleteIcon();
        
        document.querySelector('#inputMessageForm')
            .addEventListener('submit', (e) => 
            {
                e.preventDefault();

                const inputMessage = document.querySelector('.input-message');

                axios.post('/chats', {
                    message: inputMessage.value
                })
                    .then(res => {
                        inputMessage.value = '';
                        addListenerToDeleteIcon(); /** Re Instantiate listener */
                    })
                    .catch(err => console.log(err))
            })

        Echo.channel('new.chat.message.event')
            .listen('NewChatMessageEvent', ({ chat, user }) =>
            {
                if (chat.type === 'receiver')
                {
                    document.querySelector('.chat-rows')
                        .innerHTML += `
                            <div class="col-7 my-4" id="chatID${ chat.id }">
                                <div style="width: auto;">
                                    <div class="row align-items-center">
                                        <div class="col-1">
                                            <span 
                                                class="badge rounded-pill bg-dark p-2" 
                                                style="cursor: pointer;"
                                                data-toggle='tooltip'
                                                data-placement='right'
                                                title="${ user.name }"
                                            >
                                                <span class="fa-1x">${ user.name.substr(0, 1) }</span>
                                            </span>
                                        </div>
                                        <div class="col-11">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <div class="border border-dark rounded p-2" style="width: fit-content;">
                                                        ${ chat.message }
                                                    </div>
                                                </div>
                                                <div class="col">
                                                ${  
                                                    authUserID === user.id && 
                                                        `<i class='fa-solid fa-trash delete-message-icon' value='${ chat.id }' data-toggle='tooltip' data-placement='right' title='Remove'></i>`
                                                }
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                }

                if (chat.type === 'sender')
                {
                    document.querySelector('.chat-rows')
                    .innerHTML += `
                        <div class="col-7 my-4" style="margin-left: auto;" id="chatID${ chat.id }">
                            <div class="row align-items-center">
                                <div class="col-11">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            ${  
                                                authUserID === user.id && 
                                                    `<i class='fa-solid fa-trash delete-message-icon' value='${ chat.id }' data-toggle='tooltip' data-placement='right' title='Remove'></i>`
                                            }
                                        </div>
                                        <div class="col">
                                            <div class="border border-dark rounded p-2" style="width: fit-content; margin-left: auto;">
                                                ${ chat.message }
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <span 
                                        class="badge rounded-pill bg-dark p-2" 
                                        style="cursor: pointer;"
                                        data-toggle='tooltip'
                                        data-placement='right'
                                        title="${ user.name }"
                                    >
                                        <span class="fa-1x">
                                            ${ user.name.substr(0, 1) }
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    `;
                }
            });
    </script>
@endsection