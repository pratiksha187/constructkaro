@extends('layouts.app')
@section('title', 'Home | ConstructKaro')
@section('content')
  <div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Login</h2>
        <form method="POST" action="/login" class="space-y-4">
            @csrf
            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" placeholder="you@example.com"
                    class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" placeholder="••••••••"
                    class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <!-- Login Button -->
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
                Login
            </button>
            <!-- Back Link -->
            <a href="{{ route('home') }}"
                class="block text-center text-sm text-blue-600 hover:underline mt-4">
                ← Back to Home page
            </a>
        </form>
    </div>
</div>

@endsection
