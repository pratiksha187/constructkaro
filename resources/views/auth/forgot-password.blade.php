@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
  <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold mb-4 text-center text-[#1c2c3e]">Forgot Password</h2>
    <form method="POST" action="{{ route('forgot.password.send') }}">
      @csrf
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
      <label class="block text-sm font-medium text-gray-700 text-sm mb-1">Email</label>
      <input type="email" name="email" class="w-full border rounded px-3 py-2 mb-4" placeholder="Enter your registered email" required>
      <button type="submit" class="w-full bg-[#f25c05] text-white font-semibold py-2 rounded hover:bg-[#1c2c3e] transition">
        Send Reset Link
      </button>
      <a href="{{ route('login') }}" class="block text-center text-sm mt-4 text-[#1c2c3e] hover:text-[#f25c05]">← Back to Login</a>
    </form>
  </div>
</div>
@endsection
