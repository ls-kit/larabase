<x-guest-layout>
    <!-- The $slot content will be inserted here -->
    <div class="w-full">
        <!-- Logo - Centered at top -->
        {{-- <div class="flex justify-center mb-8">
            <a href="/">
                <x-application-logo class="h-16 w-auto text-indigo-600" />
            </a>
        </div> --}}

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-sm text-center text-indigo-600" :status="session('status')" />

        <!-- Form Container - Clean design without shadow -->
        <div class="bg-white p-8 rounded-xl border border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 text-center">Welcome back to Chesta Academy</h2>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Field -->
                <div class="mb-5">
                    <x-input-label for="email" class="text-gray-700 text-sm font-medium mb-2" :value="__('Email address')" />
                    <x-text-input 
                        id="email" 
                        class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-gray-800 placeholder-gray-400 rounded-lg py-2.5 px-4"
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autofocus 
                        placeholder="your@email.com"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-red-500 text-xs" />
                </div>

                <!-- Password Field -->
                <div class="mb-5">
                    <div class="flex justify-between items-center mb-2">
                        <x-input-label for="password" class="text-gray-700 text-sm font-medium" :value="__('Password')" />
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-indigo-600 hover:underline font-medium">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>
                    <x-text-input 
                        id="password" 
                        class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-gray-800 placeholder-gray-400 rounded-lg py-2.5 px-4"
                        type="password"
                        name="password"
                        required
                        placeholder="••••••••"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-red-500 text-xs" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mb-6">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4" name="remember">
                    <label for="remember_me" class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-4 rounded-lg text-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    {{ __('Sign in') }}
                </button>
            </form>

            <!-- Registration Link -->
            <div class="mt-6 pt-5 border-t border-gray-100 text-center text-sm text-gray-500">
                New to Chesta Academy? 
                <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline ml-1">
                    {{ __('Create an account') }}
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>