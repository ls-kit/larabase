<div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
        <button onclick="document.getElementById('loginModal').classList.add('hidden')" class="float-right text-gray-500">✖</button>

        <h2 class="text-xl font-bold mb-4">Login</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <input type="email" name="email" placeholder="Email" class="border w-full mb-3 p-2" required>
            <input type="password" name="password" placeholder="Password" class="border w-full mb-3 p-2" required>

            <div class="flex items-center justify-between">
                <label class="text-sm"><input type="checkbox" name="remember"> Remember me</label>
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600">Forgot?</a>
            </div>

            <button class="mt-4 w-full bg-blue-600 text-white py-2 rounded">Login</button>
        </form>
    </div>
</div>
