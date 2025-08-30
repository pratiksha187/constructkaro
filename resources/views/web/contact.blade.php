@extends('layouts.app')

@section('title', 'Contact Us - ConstructKaro')

@section('content')
<section class="relative overflow-hidden bg-gray-50">
  <div class="max-w-7xl mx-auto px-4 py-16 md:px-6 lg:px-8">
    <!-- Heading -->
    <div class="text-center mb-12">
      <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900">
        Get in <span class="text-[#f25c05]">Touch</span> with Us
      </h1>
      <p class="text-gray-600 mt-3 max-w-2xl mx-auto">
        Have questions, need support, or want to discuss your next construction project?
        Our team is here to help.
      </p>
    </div>

    <!-- Flash messages -->
    @if (session('success'))
      <div class="max-w-3xl mx-auto mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
        {{ session('success') }}
      </div>
    @endif
    @if ($errors->any())
      <div class="max-w-3xl mx-auto mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
        <ul class="list-disc pl-5 space-y-1">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- Contact Info & Form Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
      <!-- Contact Info -->
      <div class="bg-white rounded-xl shadow-md p-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Contact Information</h2>
        <p class="text-gray-600 mb-6">
          Reach out to us through any of the channels below, and our team will respond within 24 hours.
        </p>
        <ul class="space-y-4">
          <li class="flex items-center gap-4">
            <div class="bg-[#007bff]/10 p-3 rounded-full">
              <!-- phone icon -->
              <svg class="w-5 h-5 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 5a2 2 0 012-2h1.28a2 2 0 011.94 1.515l.49 1.96a2 2 0 01-.45 1.82l-.9.9a16 16 0 006.36 6.36l.9-.9a2 2 0 011.82-.45l1.96.49A2 2 0 0121 17.72V19a2 2 0 01-2 2h-1C9.82 21 3 14.18 3 6V5z"/>
              </svg>
            </div>
            <span class="text-gray-800 font-medium">+91 98765 43210</span>
          </li>
          <li class="flex items-center gap-4">
            <div class="bg-[#f25c05]/10 p-3 rounded-full">
              <!-- mail icon -->
              <svg class="w-5 h-5 text-[#f25c05]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
            </div>
            <span class="text-gray-800 font-medium">hello@constructkaro.com</span>
          </li>
          <li class="flex items-center gap-4">
            <div class="bg-[#1c2c3e]/10 p-3 rounded-full">
              <!-- map pin icon -->
              <svg class="w-5 h-5 text-[#1c2c3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 11a4 4 0 100-8 4 4 0 000 8zm0 0c-4.418 0-8 2.239-8 5v3h16v-3c0-2.761-3.582-5-8-5z"/>
              </svg>
            </div>
            <span class="text-gray-800 font-medium">Khopoli, Maharashtra, India</span>
          </li>
        </ul>

        <!-- Responsive Map -->
        <div class="mt-6">
          <div class="relative w-full overflow-hidden rounded-xl" style="padding-top: 56.25%;">
            <iframe
              class="absolute inset-0 h-full w-full"
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.805259048442!2d73.33730151090904!3d18.784111660997198!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be80714a5f1519b%3A0x1661ef613b301325!2sShreeyash%20Construction%20%7C%20Best%20Real%20Estate%20Builders%20%26%20Construction%20Company!5e1!3m2!1sen!2sin!4v1756530710073!5m2!1sen!2sin"
              style="border:0;"
              allowfullscreen
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>
          <!-- If this URL ever errors, regenerate it via Google Maps: Share → Embed a map -->
        </div>
      </div>

      <!-- Contact Form -->
      <div class="bg-white rounded-xl shadow-md p-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Send Us a Message</h2>

        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5" novalidate>
          @csrf

          <!-- honeypot -->
          <input type="text" name="company" class="hidden" tabindex="-1" autocomplete="off">

          <div>
            <label for="name" class="block text-gray-700 font-medium mb-2">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#007bff]"
                   required>
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#007bff]"
                   required>
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="phone" class="block text-gray-700 font-medium mb-2">Phone</label>
            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                   pattern="[0-9+\-\s]{7,15}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#007bff]"
                   required>
            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="message" class="block text-gray-700 font-medium mb-2">Message</label>
            <textarea id="message" name="message" rows="4"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#007bff]"
                      required>{{ old('message') }}</textarea>
            @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          <button type="submit"
                  class="bg-[#f25c05] text-white font-semibold px-6 py-3 rounded-lg hover:bg-orange-600 transition duration-300">
            Send Message
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="bg-[#1c2c3e] py-10 mt-12">
  <div class="max-w-5xl mx-auto text-center px-4">
    <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">Ready to Start Your Project?</h2>
    <p class="text-gray-300 mb-6">Join thousands of satisfied customers who trust ConstructKaro for their projects.</p>
    <a href=""
       class="bg-[#f25c05] text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-600 transition">
      Post Your Project Now
    </a>
  </div>
</section>
@endsection
