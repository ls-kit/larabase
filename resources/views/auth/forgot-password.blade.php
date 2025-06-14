<x-guest-layout>
    <!-- The $slot content will be inserted here -->
    <div class="w-full">
        <!-- Logo - Centered at top -->
        <div class="flex justify-center mb-8">
            <a href="/">
                <x-application-logo class="h-16 w-auto text-indigo-600" />
            </a>
        </div>

        <!-- Form Container -->
        <div class="bg-white p-8 rounded-xl border border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800 mb-2 text-center">Reset Your Password</h2>
            <p class="text-sm text-gray-600 text-center mb-6">
                {{ __('Forgot your password? No problem. Just enter your email and we\'ll send you a reset link.') }}
            </p>
            
            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-sm text-center text-indigo-600" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Field -->
                <div class="mb-5">
                    <x-input-label for="email" class="text-gray-700 text-sm font-medium mb-2" :value="__('Email Address')" />
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

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-4 rounded-lg text-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mb-4">
                    {{ __('Send Reset Link') }}
                </button>

                <!-- Login Link -->
                <div class="text-center text-sm text-gray-500">
                    Remember your password? 
                    <a href="{{ route('login') }}" class="text-indigo-600 font-medium hover:underline ml-1">
                        {{ __('Sign in') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>