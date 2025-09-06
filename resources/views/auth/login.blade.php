<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input id="email" class="block mt-1 w-full" 
                          type="email" 
                          name="email" 
                          placeholder="Input your email" 
                          :value="old('email')" 
                          required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          placeholder="Input your password correctly"
                          required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Forgot Password -->
        @if (Route::has('password.request'))
            <div class="flex justify-end mt-2">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" 
                   href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            </div>
        @endif

        <!-- Login & Register Buttons -->
        <div class="flex items-center justify-center mt-6 space-x-4">
            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>

            <a href="{{ route('register') }}">
                <x-secondary-button type="button">
                    {{ __('Register') }}
                </x-secondary-button>
            </a>
        </div>
    </form>
</x-guest-layout>
