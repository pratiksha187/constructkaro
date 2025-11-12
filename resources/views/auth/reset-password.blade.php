@extends('layouts.app')

@section('title', 'Reset Password | ConstructKaro')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<div class="min-h-screen flex items-center justify-center bg-gray-100">
  <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md border border-gray-200">
    <div class="text-center mb-6">
      <img src="{{ asset('logo/bg.png') }}" alt="ConstructKaro" class="h-16 mx-auto mb-4">
      <h2 class="text-2xl font-bold text-[#1c2c3e]">Reset Password</h2>
      <p class="text-gray-500 text-sm mt-1">Enter your email and new password below</p>
    </div>

    <form method="POST" action="{{ route('reset.password.submit') }}" class="space-y-4">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">

      <div>
        <label class="block text-gray-700 text-sm mb-1">Email</label>
        <input type="email" name="email" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="you@example.com" required>
      </div>

      <div>
        <label class="block text-gray-700 text-sm mb-1">New Password</label>
        <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Enter new password" required>
      </div>

      <div>
        <label class="block text-gray-700 text-sm mb-1">Confirm Password</label>
        <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Re-enter password" required>
      </div>

      <button type="submit" class="w-full bg-[#f25c05] hover:bg-[#1c2c3e] text-white font-semibold py-2 rounded-lg shadow transition duration-300">
        Reset Password
      </button>

      <a href="{{ route('login') }}" class="block text-center text-sm mt-4 text-[#1c2c3e] hover:text-[#f25c05]">
        ← Back to Login
      </a>
    </form>
  </div>
</div>
@endsection
