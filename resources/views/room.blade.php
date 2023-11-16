@extends('layouts.app')
@section('content')
    <div id="data-wrapper"
         data-chat-id="{{$chat->id}}"
         data-user-id="<?php echo \Illuminate\Support\Facades\Auth::id() ?>"
         data-user='<?php echo \Illuminate\Support\Facades\Auth::user()->toJson() ?>'
         data-user-isMember="<?php echo json_encode(\Illuminate\Support\Facades\Auth::user()->isRoomMember($chat)) ?>"
         class="mt-16 w-full relative text-white">
        @if(!\Illuminate\Support\Facades\Auth::user()->isRoomMember($chat))
            <div id="shadow-paper"
                 class="absolute inset-0 bg-gray-500 flex flex-col items-center justify-center rounded-lg">
                <button
                    id="join-chat-button"
                    class="py-3 px-6 text-gray-100 dark:text-gray-900 bg-gray-800 dark:bg-gray-200 hover:bg-gray-700 dark:hover:bg-gray-300 rounded-lg transition">
                    Join This Room
                </button>
            </div>
        @endif
        <div
            class="w-full p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
            <div class="flex items-center space-x-4 mb-1">
                <div
                    class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         class="w-7 h-7 stroke-red-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6.115 5.19l.319 1.913A6 6 0 008.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 002.288-4.042 1.087 1.087 0 00-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 01-.98-.314l-.295-.295a1.125 1.125 0 010-1.591l.13-.132a1.125 1.125 0 011.3-.21l.603.302a.809.809 0 001.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 001.528-1.732l.146-.292M6.115 5.19A9 9 0 1017.18 4.64M6.115 5.19A8.965 8.965 0 0112 3c1.929 0 3.716.607 5.18 1.64"/>
                    </svg>
                </div>

                <div class="flex items-center sm:justify-between w-full">
                    <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Chat Room</h2>
                    <h2 id="leave-chat-room" class="mt-6 font-semibold text-gray-900 dark:text-white hover:underline cursor-pointer">Leave This Room</h2>
                </div>
            </div>

            <div class="py-4 flex w-full">
                <div id="users" class="hidden md:flex flex-col divide-y dark:divide-gray-100/50 w-1/5 border-r p-2 pr-1">
                    <div class="dark:text-gray-100 text-lg">Users</div>
                    @foreach($chat->users as $user)
                        <div id="user-<?php echo $user->id ?>" class="flex items-center space-x-2 py-1">
                            <div>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/59/User-avatar.svg"/>
                            </div>
                            <div class="text-sm dark:text-gray-100 truncate">{{$user->name}}</div>
                        </div>
                    @endforeach
                </div>
                <div id="messages" class="w-full md:w-3/4 p-2">
                    <div class="dark:text-gray-100 text-lg border-b border-gray-100/50">Messages</div>
                    <div id="messages-container" class="py-4 flex flex-col space-y-4 h-[40vh] overflow-y-auto">
                        @foreach($chat->messages as $message)
                            <div
                                class="flex {{$message->sender && $message->sender->id===\Illuminate\Support\Facades\Auth::id() ? 'justify-end' : ''}}">
                                <div
                                    class="w-64 {{$message->sender && $message->sender->id===\Illuminate\Support\Facades\Auth::id() ? 'bg-gray-300 dark:bg-gray-600' : 'bg-gray-200 dark:bg-gray-700'}} rounded-lg p-1">
                                    <div class="flex items-center space-x-1 text-xs dark:text-gray-300">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/59/User-avatar.svg"/>
                                        <div>{{$message->sender ? $message->sender->name : 'Deleted Account'}}</div>
                                    </div>
                                    <div class="text-sm text-gray-90 dark:text-gray-100">{{$message->message}}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div id="whispering" class="mt-1 text-xs dark:text-gray-100 animate-pulse"></div>
                    <div class="flex items-center py-2 space-x-1 border-t">
                        <div class="flex-1"><textarea id="message-box"
                                                      rows="1"
                                                      class="w-full px-2 py-3 rounded-lg dark:text-gray-100 dark:bg-gray-600 text-sm"
                                                      placeholder="Your Message..."></textarea></div>
                        <div id="send-button"
                             class="border border-gray-900 dark:border-gray-100 rounded-full p-1 cursor-pointer hover:bg-gray-100 hover:text-gray-900 text-gray-900 dark:text-gray-100 transition">
                            <svg class="" height="24" viewBox="0 0 24 24" width="24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <g fill="currentColor" fill-rule="nonzero">
                                    <path
                                        d="m3.45559904 3.48107721 3.26013002 7.74280879c.20897233.4963093.20897233 1.0559187 0 1.552228l-3.26013002 7.7428088 18.83130296-8.5189228zm-.74951511-1.43663117 20.99999997 9.49999996c.3918881.1772827.3918881.7338253 0 .911108l-20.99999997 9.5c-.41424571.1873968-.8433362-.2305504-.66690162-.6495825l3.75491137-8.9179145c.10448617-.2481546.10448617-.5279594 0-.776114l-3.75491137-8.9179145c-.17643458-.41903214.25265591-.83697933.66690162-.64958246z"/>
                                    <path d="m6 12.5v-1h16.5v1z"/>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
