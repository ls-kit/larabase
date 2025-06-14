<x-guest-layout>
    <!-- The $slot content will be inserted here -->
    <div class="w-full">
        <!-- Logo - Centered at top -->
        <div class="flex justify-center mb-8">
            <a href="/">
                <x-application-logo class="h-16 w-auto text-indigo-600" />
            </a>
        </div>

        <!-- Form Container - Clean design -->
        <div class="bg-white p-8 rounded-xl border border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 text-center">Join Chesta Academy</h2>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name Field -->
                <div class="mb-5">
                    <x-input-label for="name" class="text-gray-700 text-sm font-medium mb-2" :value="__('Full Name')" />
                    <x-text-input 
                        id="name" 
                        class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-gray-800 placeholder-gray-400 rounded-lg py-2.5 px-4"
                        type="text" 
                        name="name" 
                        :value="old('name')" 
                        required 
                        autofocus 
                        placeholder="John Doe"
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-red-500 text-xs" />
                </div>

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
                        placeholder="your@email.com"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-red-500 text-xs" />
                </div>

                <!-- Password Field -->
                <div class="mb-5">
                    <x-input-label for="password" class="text-gray-700 text-sm font-medium mb-2" :value="__('Password')" />
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

                <!-- Confirm Password Field -->
                <div class="mb-6">
                    <x-input-label for="password_confirmation" class="text-gray-700 text-sm font-medium mb-2" :value="__('Confirm Password')" />
                    <x-text-input 
                        id="password_confirmation" 
                        class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-gray-800 placeholder-gray-400 rounded-lg py-2.5 px-4"
                        type="password"
                        name="password_confirmation" 
                        required
                        placeholder="••••••••"
                    />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-red-500 text-xs" />
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-4 rounded-lg text-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    {{ __('Create Account') }}
                </button>

                <!-- Login Link -->
                <div class="mt-6 pt-5 border-t border-gray-100 text-center text-sm text-gray-500">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-indigo-600 font-medium hover:underline ml-1">
                        {{ __('Sign in') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>