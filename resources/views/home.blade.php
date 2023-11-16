@extends('layouts.app')
@section('content')
    <div class="mt-16 w-full relative grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
        @foreach($chats as $chat)
            <div
                class="w-full hover:scale-[1.05] aspect-video p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                <div class="text-gray-900 dark:text-gray-100 text-2xl font-bold">
                    {{$chat->title}}
                </div>
                <div class="text-gray-900 dark:text-gray-100 text-sm mt-4">
                    Online Users: {{$chat->users_count}}
                </div>
                <div class="mt-4 text-center">
                    <a class="block w-full px-3 py-2 rounded-lg bg-gray-700 hover:bg-gray-800 text-gray-100 dark:bg-gray-300 dark:hover:bg-gray-200 dark:text-gray-900 transition-all"
                       href="{{route('room',['chat'=>$chat])}}">Enter</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
