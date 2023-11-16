@extends('layouts.app')

@section('content')
    <div class="mt-16 w-full relative">
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
                    <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">{{ __('Login') }}</h2>
                </div>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="flex flex-col p-8 w-full lg:w-1/3 text-gray-900 dark:text-gray-100">
                    <div>
                        <label for="email">{{ __('Email Address') }}</label>
                        <div class="">
                            <input id="email" type="email"
                                   class="w-full py-2 px-1 rounded-lg bg-gray-200 dark:bg-gray-700 dark:text-gray-100 @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email"
                                   autofocus>
                            @error('email')
                            <span class="text-red-500 text-sm" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="password">{{ __('Password') }}</label>
                        <div class="">
                            <input id="password" type="password"
                                   class="w-full py-2 px-1 rounded-lg bg-gray-200 dark:bg-gray-700 dark:text-gray-100 @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember"
                                       id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="py-2 px-3 rounded-lg bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 transition">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="py-2 px-3 rounded-lg hover:text-gray-500 dark:hover:text-gray-500 transition" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
