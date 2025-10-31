@extends('layouts.app')

@section('title', 'Login | ConstructKaro')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<style>
    .h-16 {
    height: 13rem;
}
</style>
<div class="min-h-screen flex bg-gradient-to-br from-[#f6f8fa] to-[#eef2f7]">

    <!-- Left Section -->
    <div class="hidden lg:flex lg:w-1/2 bg-[#1c2c3e] text-white items-center justify-center relative">
        <div class="p-12 max-w-md text-center">
            <img src="{{ asset('logo/bg.png') }}" alt="ConstructKaro Logo" class="mx-auto mb-6 h-16">
            <h2 class="text-3xl font-bold mb-4">Welcome to ConstructKaro</h2>
            <p class="text-gray-300 text-sm leading-relaxed">
                Building the future of construction through technology and trusted partnerships.  
                Login to continue to your dashboard and manage your projects with ease.
            </p>
        </div>
    </div>

    <!-- Right Section -->
    <div class="flex items-center justify-center w-full lg:w-1/2 px-6 lg:px-16">
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-gray-100">

            <h2 class="text-2xl font-bold text-center mb-2 text-[#1c2c3e]">Login to Your Account</h2>
            <p class="text-center text-gray-500 text-sm mb-6">Enter your credentials below</p>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Login As -->
                <div>
                    <label for="login_as" class="block text-sm font-medium text-gray-700 mb-1">Login As</label>
                    <select name="login_as" id="login_as"
                        class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#f25c05]" required>
                        <option value="">-- Select Role --</option>
                        <option value="staff">Staff</option>
                        <option value="vendor">Vendor</option>
                        <option value="customer">Customer</option>
                    </select>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            placeholder="you@example.com" autocomplete="email"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f25c05]" required>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" placeholder="••••••••"
                            autocomplete="current-password"
                            class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f25c05]" required>
                        <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer text-gray-500" onclick="togglePassword()">
                            <i id="toggleIcon" class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-[#f25c05] hover:bg-[#1c2c3e] text-white font-semibold py-2 px-4 rounded-lg transition duration-300 ease-in-out shadow-md">
                    Login
                </button>

                <!-- Back Link -->
                <a href="{{ route('home') }}" class="block text-center text-sm text-[#1c2c3e] hover:text-[#f25c05] mt-3">
                    ← Back to Home page
                </a>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.replace("bi-eye", "bi-eye-slash");
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.replace("bi-eye-slash", "bi-eye");
    }
}

// SweetAlert for Laravel error message
@if(session('error'))
Swal.fire({
    icon: 'error',
    title: 'Login Failed',
    text: '{{ session('error') }}',
    confirmButtonColor: '#f25c05',
    confirmButtonText: 'Try Again'
});
@endif
</script>
@endsection
