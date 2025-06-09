
<div id="authModal" class="fixed inset-0 hidden bg-primary-dark/75 backdrop-blur-sm overflow-y-auto flex items-start md:items-center justify-center p-4 z-50">
  <div id="modalContent" class="relative bg-white rounded-xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto p-6 transition-transform transform scale-95 opacity-0">
    <!-- Close Button -->
    <button id="closeModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>

    <!-- Tabs -->
    <div class="flex border-b mb-4">
      <button class="tab-button active flex-1 py-2 font-bold text-primary" data-tab="login">Login</button>
      <button class="tab-button flex-1 py-2 font-bold text-gray-500" data-tab="register">Register</button>
    </div>

<!-- Login Form -->
<div id="login" class="tab-content">
  <h3 class="text-2xl font-bold text-primary mb-4">Welcome Back!</h3>

  @if(session('status'))
    <p class="text-green-500 mb-4">{{ session('status') }}</p>
  @endif

  <form method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf
    <div>
      <label class="block text-gray-700 mb-1">Email</label>
      <input name="email" type="email" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-accent" value="{{ old('email') }}">
      @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Password</label>
      <input name="password" type="password" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-accent">
      @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    <button type="submit" class="w-full bg-highlight text-white py-3 rounded-lg font-bold">Login & Continue</button>
  </form>
</div>



<!-- Register Form -->
<div id="register" class="tab-content hidden">
  <h3 class="text-2xl font-bold text-primary mb-4">Create Your Account</h3>

  <form method="POST" action="{{ route('register') }}" class="space-y-4">
    @csrf
    <div>
      <label class="block text-gray-700 mb-1">Full Name</label>
      <input name="name" type="text" value="{{ old('name') }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-accent">
      @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Email</label>
      <input name="email" type="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-accent">
      @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Password</label>
      <input name="password" type="password" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-accent">
      @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Confirm Password</label>
      <input name="password_confirmation" type="password" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-accent">
    </div>
    <button type="submit" class="w-full bg-highlight text-white py-3 rounded-lg font-bold">Create Account</button>
  </form>
</div>


</div>
</div>

<!-- JS: jQuery + Modal Logic -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
  // Open modal
  $('.auth-trigger').click(function(){
    $('#authModal').removeClass('hidden');
    $('#modalContent').removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
    $('body').css('overflow','hidden');
  });
  // Close modal
  $('#closeModal, #authModal').click(function(e){
    if (e.target.id === 'closeModal' || e.target.id === 'authModal') {
      $('#modalContent').removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
      setTimeout(function(){
        $('#authModal').addClass('hidden');
        $('body').css('overflow','auto');
      }, 200);
    }
  });
  // Tab switching
  $('.tab-button').click(function(){
    const tab = $(this).data('tab');
    $('.tab-button').removeClass('active text-primary').addClass('text-gray-500');
    $(this).addClass('active text-primary').removeClass('text-gray-500');
    $('.tab-content').addClass('hidden');
    $('#' + tab).removeClass('hidden');
  });
});
</script>