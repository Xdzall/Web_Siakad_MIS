<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login SIAKAD MIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-cover bg-center relative" style="background-image: url('Login.png');">
    <!-- Overlay hitam transparan -->
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>

    <!-- Form login di tengah -->
    <div class="relative z-10 flex items-center justify-center min-h-screen">
        <div class="bg-white bg-opacity-90 rounded-lg shadow-lg p-8 w-full max-w-md mx-auto">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <h2 class="text-3xl font-bold text-center text-[#1E3A8A] mb-6">Login SIAKAD MIS</h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-[#1E3A8A]" />
                    <x-text-input
                        id="email"
                        class="block mt-1 w-full border border-gray-300 rounded-xl text-lg py-3 px-4"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-[#1E3A8A]" />
                    <x-text-input
                        id="password"
                        class="block mt-1 w-full border border-gray-300 rounded-xl text-lg py-3 px-4"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-[#1E3A8A] shadow-sm focus:ring-[#1E3A8A]"
                        name="remember">
                    <label for="remember_me" class="ml-2 text-sm text-[#1E3A8A]">{{ __('Remember me') }}</label>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-[#1E3A8A] hover:text-[#144a85]"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ml-3 bg-[#1E3A8A] text-white hover:bg-[#163372]">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
